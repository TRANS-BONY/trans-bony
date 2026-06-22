@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 p-6 shadow-xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Clients & Passagers</h1>
                    <p class="text-indigo-100 mt-1">Espace dédié à la gestion de la clientèle</p>
                </div>
            </div>
            <!-- Bouton pour ajouter un client formellement -->
            <button class="px-5 py-2.5 bg-white text-indigo-700 font-bold rounded-xl shadow-lg hover:bg-indigo-50 transition">
                <i class="fas fa-plus mr-2"></i> Nouveau client
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 font-semibold text-gray-600">ID</th>
                        <th class="p-4 font-semibold text-gray-600">Nom & Prénom</th>
                        <th class="p-4 font-semibold text-gray-600">Contact</th>
                        <th class="p-4 font-semibold text-gray-600">Type</th>
                        <th class="p-4 font-semibold text-gray-600">Inscrit le</th>
                        <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="p-4 font-medium text-gray-900">#{{ $client->id }}</td>
                            <td class="p-4 font-bold text-indigo-600">
                                {{ $client->nom }} {{ $client->prenom }}
                            </td>
                            <td class="p-4">
                                <div class="text-sm">
                                    <i class="fas fa-phone text-gray-400 mr-1"></i> {{ $client->telephone ?? 'N/A' }}<br>
                                    <i class="fas fa-envelope text-gray-400 mr-1"></i> {{ $client->email ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $client->type === 'vip' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($client->type ?? 'Standard') }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500">{{ $client->created_at->format('d/m/Y') }}</td>
                            <td class="p-4 text-right flex gap-2 justify-end">
                                <button class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="px-3 py-1.5 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg shadow transition">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Aucun client trouvé dans le système</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($clients->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
