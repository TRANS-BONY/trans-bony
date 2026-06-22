@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-600 p-6 shadow-xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-box-open text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Colis & Marchandises</h1>
                    <p class="text-blue-100 mt-1">Plateforme logistique d'expédition</p>
                </div>
            </div>
            <button class="px-5 py-2.5 bg-white text-blue-700 font-bold rounded-xl shadow-lg hover:bg-blue-50 transition">
                <i class="fas fa-plus mr-2"></i> Enregistrer un colis
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
                        <th class="p-4 font-semibold text-gray-600">Expéditeur</th>
                        <th class="p-4 font-semibold text-gray-600">Destinataire</th>
                        <th class="p-4 font-semibold text-gray-600">Poids</th>
                        <th class="p-4 font-semibold text-gray-600">Montant</th>
                        <th class="p-4 font-semibold text-gray-600 text-center">Statut</th>
                        <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($colis as $item)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="p-4 font-medium text-gray-900">#{{ $item->id }}</td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $item->expediteur_nom }}</div>
                                <div class="text-xs text-gray-500">{{ $item->expediteur_tel }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $item->destinataire_nom }}</div>
                                <div class="text-xs text-gray-500">{{ $item->destinataire_tel }}</div>
                            </td>
                            <td class="p-4"><span class="bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono text-sm">{{ $item->poids_kg }} kg</span></td>
                            <td class="p-4 font-bold text-blue-600">{{ number_format($item->montant, 0, ',', ' ') }} FCFA</td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $item->statut === 'livre' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($item->statut ?? 'En attente') }}
                                </span>
                            </td>
                            <td class="p-4 text-right flex gap-2 justify-end">
                                <button class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-box mb-3 text-3xl opacity-50"></i>
                                    Aucun colis enregistré dans le système pour le moment.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($colis->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $colis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
