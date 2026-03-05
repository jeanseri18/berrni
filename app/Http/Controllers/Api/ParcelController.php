<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Parcel::with(['sender', 'courier']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show published parcels for couriers to find
            $query->where('status', 'published');
        }

        // Search by location
        if ($request->has('departure')) {
            $query->where('departure_address', 'like', '%' . $request->departure . '%');
        }
        if ($request->has('destination')) {
            $query->where('destination_address', 'like', '%' . $request->destination . '%');
        }

        return response()->json($query->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'departure_address' => 'required|string',
            'destination_address' => 'required|string',
            'departure_date' => 'required|date',
            'recipient_name' => 'required|string',
            'recipient_phone' => 'required|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $parcel = Parcel::create([
            'sender_id' => $request->user()->id,
            'description' => $request->description,
            'departure_address' => $request->departure_address,
            'destination_address' => $request->destination_address,
            'departure_date' => $request->departure_date,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'price' => $request->price,
            'weight' => $request->weight,
            'status' => 'published',
            'payment_status' => 'pending', // In real app, prompt payment here
        ]);

        return response()->json($parcel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $parcel = Parcel::with(['sender', 'courier', 'messages'])->findOrFail($id);
        return response()->json($parcel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $parcel = Parcel::findOrFail($id);

        // Check ownership
        if ($parcel->sender_id !== $request->user()->id && $parcel->courier_id !== $request->user()->id && !$request->user()->role === 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $parcel->update($request->all());
        return response()->json($parcel);
    }

    /**
     * Courier accepts a parcel
     */
    public function accept(Request $request, $id)
    {
        $parcel = Parcel::findOrFail($id);

        if ($parcel->status !== 'published') {
            return response()->json(['message' => 'Colis déjà assigné ou indisponible'], 400);
        }

        if (!$request->user()->is_courier) {
             return response()->json(['message' => 'Vous devez être un relais validé'], 403);
        }

        $parcel->update([
            'courier_id' => $request->user()->id,
            'status' => 'assigned',
        ]);

        return response()->json(['message' => 'Colis accepté avec succès', 'parcel' => $parcel]);
    }
}
