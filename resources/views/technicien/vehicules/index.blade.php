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
    
    /* By default, all direct children shouldn't shrink (Headers, Stats, Pagination) */
    .module-index-wrapper > * {
        flex-shrink: 0;
    }
    
    /* The main list container gets flex-1 and scroll */
    .module-index-wrapper > .grid:not(.grid-cols-2.md\:grid-cols-4), /* Match grids except the stats grid */
    .module-index-wrapper > .animate-fade-in-up > .grid:not(.grid-cols-2.md\:grid-cols-4), /* Nested grid */
    .module-index-wrapper > .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }
    
    /* Fix for nested list containers in some views */
    .module-index-wrapper > .animate-fade-in-up:nth-last-child(2) {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        display: flex;
        flex-direction: column;
    }
    .module-index-wrapper > .animate-fade-in-up:nth-last-child(2) > .grid,
    .module-index-wrapper > .animate-fade-in-up:nth-last-child(2) > .hidden.lg\:block {
        flex: 1 1 0% !important;
        overflow-y: auto !important;
        min-height: 0 !important;
    }
</style>
<div class="module-index-wrapper custom-scrollbar">

<div class="module-index-wrapper custom-scrollbar">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Parc Automobile</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultation de l'état des véhicules</p>
        </div>
    </div>    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col list-scroll-container">
        <div class="overflow-x-auto overflow-y-auto flex-1 custom-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 text-xs uppercase tracking-widest font-bold">
                        <th class="px-6 py-4">Immatriculation</th>
                        <th class="px-6 py-4">Modèle</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Capacité</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($vehicules as $v)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $v->immatriculation }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $v->marque }} {{ $v->modele }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-[10px] font-bold rounded-lg uppercase
                                {{ $v->statut == 'disponible' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $v->statut == 'maintenance' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $v->statut == 'mission' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ $v->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $v->capacite }} places</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('technicien.vehicules.show', $v) }}" class="p-2 text-gray-400 hover:text-teal-600"><i class="fas fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            Aucun véhicule disponible.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 shrink-0">
            {{ $vehicules->links() }}
        </div>
    </div>

</div>
@endsection
