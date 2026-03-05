@extends('layouts.admin')

@section('title', 'SOS Alertes & Litiges')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if($alerts->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-shield-alt text-4xl mb-4 text-gray-300"></i>
                <p>Aucune alerte en cours. Tout va bien !</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 p-4">
                @foreach($alerts as $alert)
                    <div class="border border-red-200 rounded-lg p-4 bg-red-50 flex flex-col md:flex-row justify-between items-start">
                        <div class="mb-4 md:mb-0">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="px-2 py-0.5 bg-red-200 text-red-800 text-xs font-bold rounded uppercase">SOS #{{ $alert->id }}</span>
                                <span class="text-gray-500 text-sm">{{ $alert->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="font-bold text-red-800 text-lg mb-1">Motif : {{ $alert->reason }}</h4>
                            <p class="text-gray-700 text-sm mb-2">
                                Signalé par <span class="font-medium">{{ $alert->user->name }}</span> 
                                pour le colis <span class="font-medium">#{{ $alert->parcel_id }}</span>
                            </p>
                            <div class="text-sm text-gray-600 bg-white p-3 rounded border border-red-100">
                                <p class="font-medium text-xs text-gray-400 uppercase mb-1">Détails du colis</p>
                                {{ $alert->parcel->description }} ({{ $alert->parcel->departure_address }} -> {{ $alert->parcel->destination_address }})
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-sm">Contacter</button>
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm shadow-sm">Résoudre</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
