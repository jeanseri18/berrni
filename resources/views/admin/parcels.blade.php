@extends('layouts.admin')

@section('title', 'Gestion des Colis')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 font-medium text-gray-500">ID</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Expéditeur</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Relais</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Trajet</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Prix</th>
                    <th class="px-6 py-4 font-medium text-gray-500">Statut</th>
                    <th class="px-6 py-4 font-medium text-gray-500 text-right">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($parcels as $parcel)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500">#{{ $parcel->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $parcel->sender->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $parcel->courier ? $parcel->courier->name : '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col text-sm">
                                <span class="text-gray-800">{{ $parcel->departure_address }}</span>
                                <span class="text-gray-400 text-xs">vers</span>
                                <span class="text-gray-800">{{ $parcel->destination_address }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">{{ number_format($parcel->price, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                {{ $parcel->status === 'published' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $parcel->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $parcel->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                {{ in_array($parcel->status, ['assigned', 'picked_up', 'in_transit']) ? 'bg-orange-100 text-orange-700' : '' }}
                            ">
                                {{ $parcel->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-gray-500 text-sm">{{ $parcel->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $parcels->links() }}
        </div>
    </div>
@endsection
