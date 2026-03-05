@extends('layouts.admin')

@section('title', 'Gestion des Expéditeurs')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-blue-50">
            <h3 class="font-bold text-blue-800"><i class="fas fa-paper-plane mr-2"></i> Expéditeurs Actifs</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 font-medium text-gray-500">Nom</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Contact</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Colis Envoyés</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Dépenses Totales</th>
                    <th class="px-6 py-4 font-medium text-gray-500 text-right">Dernier envoi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user->id) }}'">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->phone }}<br>{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-700 font-medium">
                            {{ $user->sentParcels->count() }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ number_format($user->sentParcels->sum('price'), 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-500">
                            {{ $user->sentParcels->last() ? $user->sentParcels->last()->created_at->format('d/m/Y') : '-' }}
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
