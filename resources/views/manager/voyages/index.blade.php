@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Opérations / Voyages</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultation globale des voyages</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-medium">Itinéraire</th>
                        <th class="p-4 font-medium">Départ - Arrivée</th>
                        <th class="p-4 font-medium">Véhicule & Chauffeur</th>
                        <th class="p-4 font-medium">Statut</th>
                        <th class="p-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($voyages as $v)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="p-4">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $v->ville_depart }} <i class="fas fa-arrow-right text-gray-400 text-xs mx-1"></i> {{ $v->ville_arrivee }}</p>
                        </td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">
                            {{ $v->date_depart->format('d/m/Y H:i') }}<br>
                            <span class="text-xs text-gray-400">{{ $v->date_arrivee ? $v->date_arrivee->format('d/m/Y H:i') : '-' }}</span>
                        </td>
                        <td class="p-4">
                            <p class="text-gray-900 dark:text-gray-300"><i class="fas fa-bus text-gray-400 text-xs mr-1"></i> {{ $v->vehicule->immatriculation ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500"><i class="fas fa-user text-gray-400 text-xs mr-1"></i> {{ $v->chauffeur->nom ?? 'N/A' }}</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700">{{ ucfirst($v->statut) }}</span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('manager.voyages.show', $v) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-500">Aucun voyage enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($voyages->hasPages())
        <div class="p-4 bg-gray-50">{{ $voyages->links() }}</div>
        @endif
    </div>
</div>
@endsection
