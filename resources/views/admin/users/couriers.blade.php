@extends('layouts.admin')

@section('title', 'Gestion des Livreurs (Relais)')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-green-50">
            <h3 class="font-bold text-green-800"><i class="fas fa-truck mr-2"></i> Relais de Confiance</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 font-medium text-gray-500">Nom</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Contact</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Statut</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Colis Livrés</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Gain (Wallet)</th>
                    <th class="px-6 py-4 font-medium text-gray-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user->id) }}'">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->phone }}<br>{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->courier_status === 'approved')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase">Validé</span>
                            @elseif($user->courier_status === 'pending')
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-bold uppercase">En attente</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold uppercase">{{ $user->courier_status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">
                            {{ $user->deliveredParcels->count() }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $user->wallet ? number_format($user->wallet->balance_available, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                <i class="fas fa-eye mr-1"></i> Détails
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
