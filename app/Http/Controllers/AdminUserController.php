<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function show($id)
    {
        $user = User::with(['wallet', 'sentParcels', 'deliveredParcels', 'kycSubmissions'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
