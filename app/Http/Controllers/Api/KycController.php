<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KycSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KycController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_card_front' => 'required|file|image|max:2048', // 2MB Max
            'id_card_back' => 'required|file|image|max:2048',
            'selfie' => 'required|file|image|max:2048',
            'selfie_with_id' => 'required|file|image|max:2048',
            'transport_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Store files
        $paths = [];
        foreach (['id_card_front', 'id_card_back', 'selfie', 'selfie_with_id'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('kyc-documents', 'public');
                $paths[$field] = 'storage/' . $path;
            }
        }

        $submission = KycSubmission::create([
            'user_id' => $request->user()->id,
            'transport_type' => $request->transport_type,
            'status' => 'pending',
            'id_card_front' => $paths['id_card_front'],
            'id_card_back' => $paths['id_card_back'],
            'selfie' => $paths['selfie'],
            'selfie_with_id' => $paths['selfie_with_id'],
        ]);

        $request->user()->update(['courier_status' => 'pending']);

        return response()->json(['message' => 'Dossier soumis avec succès', 'submission' => $submission], 201);
    }

    public function status(Request $request)
    {
        $submission = KycSubmission::where('user_id', $request->user()->id)->latest()->first();
        return response()->json(['status' => $request->user()->courier_status, 'submission' => $submission]);
    }
}
