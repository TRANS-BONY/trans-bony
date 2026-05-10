@extends('layouts.technicien')

@section('content')
<style>
    /* Désactiver le scroll global */
    html, body { overflow: hidden !important; height: 100vh !important; }
    
    /* Scrollbar minimaliste */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
    
    /* Wrapper Layout */
    .module-index-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        height: calc(100vh - 100px);
        overflow: hidden;
        padding-bottom: 0.5rem;
    }
    
    .module-index-wrapper > * {
        flex-shrink: 0;
    }
    
    .module-index-wrapper > .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }
</style>
<div class="module-index-wrapper custom-scrollbar">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Maintenances</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Liste complète des interventions sur le parc</p>
        </div>
        <a href="{{ route('technicien.maintenances.create') }}" class="flex items-center gap-2 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition shadow-sm">
            <i class="fas fa-plus"></i> Nouvelle Maintenance
        </a>
    </div>

    {{-- TABLEAU DES MAINTENANCES --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col list-scroll-container">
        <div class="overflow-x-auto overflow-y-auto flex-1 custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                        <th class="p-4 font-medium">Véhicule</th>
                        <th class="p-4 font-medium">Type</th>
                        <th class="p-4 font-medium">Date Prévue</th>
                        <th class="p-4 font-medium">Statut</th>
                        <th class="p-4 font-medium">Coût</th>
                        <th class="p-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($maintenances as $m)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="p-4">
                            <a href="{{ route('technicien.vehicules.show', $m->vehicule_id) }}" class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 transition">
                                {{ $m->vehicule->immatriculation ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="p-4 text-gray-500 dark:text-gray-400">{{ ucfirst($m->type) }}</td>
                        <td class="p-4 font-medium text-gray-700 dark:text-gray-300">{{ $m->date_prevue->format('d/m/Y') }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-lg
                                {{ $m->statut == 'terminee' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ ucfirst($m->statut) }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500 dark:text-gray-400">
                            {{ $m->cout ? number_format($m->cout, 0, ',', ' ') . ' Franc CFA' : '-' }}
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('technicien.maintenances.show', $m) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('technicien.maintenances.edit', $m) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-orange-600 hover:bg-orange-50 transition" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('technicien.maintenances.destroy', $m) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette maintenance ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-tools text-3xl mb-3 opacity-50"></i>
                            <p>Aucune maintenance n'est enregistrée.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenances->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 shrink-0">
            {{ $maintenances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
