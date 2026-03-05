@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-700">Tous les utilisateurs</h3>
            <!-- Search placeholder -->
            <div class="relative">
                <input type="text" placeholder="Rechercher..." class="pl-8 pr-4 py-2 border rounded-lg text-sm focus:ring-berrni-500 focus:border-berrni-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </div>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 font-medium text-gray-500">ID</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Nom</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Email / Téléphone</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Rôle</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Statut Relais</th>
                    <th class="px-6 py-4 font-medium text-gray-500 text-right">Inscrit le</th>
                    <th class="px-6 py-4 font-medium text-gray-500 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user->id) }}'">
                        <td class="px-6 py-4 text-gray-500">#{{ $user->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $user->name }}
                            @if($user->role === 'admin')
                                <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded-full">Admin</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col text-sm">
                                <span class="text-gray-800">{{ $user->email }}</span>
                                <span class="text-gray-500">{{ $user->phone }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_courier)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase">Relais</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold uppercase">Utilisateur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                             @if($user->courier_status === 'approved')
                                <span class="text-green-600 font-medium text-sm"><i class="fas fa-check-circle mr-1"></i> Validé</span>
                             @elseif($user->courier_status === 'pending')
                                <span class="text-orange-500 font-medium text-sm"><i class="fas fa-clock mr-1"></i> En attente</span>
                             @elseif($user->courier_status === 'rejected')
                                <span class="text-red-500 font-medium text-sm"><i class="fas fa-times-circle mr-1"></i> Refusé</span>
                             @else
                                <span class="text-gray-400 text-sm">-</span>
                             @endif
                        </td>
                        <td class="px-6 py-4 text-right text-gray-500 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                             <a href="{{ route('admin.users.show', $user->id) }}" class="text-berrni-600 hover:text-berrni-800">
                                <i class="fas fa-chevron-right"></i>
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
