@extends('layouts.admin')

@section('title', 'Validations KYC en attente')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if($submissions->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-check-circle text-4xl mb-4 text-gray-300"></i>
                <p>Aucune demande de validation en attente.</p>
            </div>
        @else
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-medium text-gray-500">Utilisateur</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Email</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Transport</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Date</th>
                        <th class="px-6 py-4 font-medium text-gray-500 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($submissions as $sub)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $sub->user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $sub->user->email }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs uppercase font-bold">{{ $sub->transport_type }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $sub->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.kyc.show', $sub->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm">
                                    Examiner
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
