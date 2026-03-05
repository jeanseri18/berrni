<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parcel;
use App\Models\KycSubmission;
use App\Models\SosAlert;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'couriers_pending' => KycSubmission::where('status', 'pending')->count(),
            'active_parcels' => Parcel::whereIn('status', ['published', 'assigned', 'picked_up', 'in_transit'])->count(),
            'sos_alerts' => SosAlert::where('status', 'open')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function kycList()
    {
        $submissions = KycSubmission::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.kyc_list', compact('submissions'));
    }

    public function kycShow($id)
    {
        $submission = KycSubmission::with('user')->findOrFail($id);
        return view('admin.kyc_show', compact('submission'));
    }

    public function kycApprove($id)
    {
        $submission = KycSubmission::findOrFail($id);
        $submission->update(['status' => 'approved']);
        
        $user = $submission->user;
        $user->update(['is_courier' => true, 'courier_status' => 'approved']);

        return redirect()->route('admin.kyc.list')->with('success', 'Relais validé avec succès.');
    }

    public function kycReject(Request $request, $id)
    {
        $submission = KycSubmission::findOrFail($id);
        $submission->update([
            'status' => 'rejected', 
            'admin_notes' => $request->input('reason')
        ]);
        
        $user = $submission->user;
        $user->update(['courier_status' => 'rejected']);

        return redirect()->route('admin.kyc.list')->with('success', 'Relais refusé.');
    }

    public function parcels()
    {
        $parcels = Parcel::with(['sender', 'courier'])->latest()->paginate(20);
        return view('admin.parcels', compact('parcels'));
    }

    public function sos()
    {
        $alerts = SosAlert::with(['user', 'parcel'])->where('status', 'open')->get();
        return view('admin.sos', compact('alerts'));
    }

    // New methods for User Management

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function couriers()
    {
        $users = User::where('is_courier', true)
                     ->orWhere('courier_status', '!=', 'none')
                     ->latest()
                     ->paginate(20);
        return view('admin.users.couriers', compact('users'));
    }

    public function senders()
    {
        // Users who are not couriers or have sent parcels
        $users = User::where('is_courier', false)
                     ->whereHas('sentParcels')
                     ->latest()
                     ->paginate(20);
        return view('admin.users.senders', compact('users'));
    }
}
