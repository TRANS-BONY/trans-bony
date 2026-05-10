@extends('layouts.manager')

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
    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Parc Automobile</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultation globale des véhicules</p>
        </div>
    </div>
    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>
<div class="list-scroll-container custom-scrollbar grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @forelse($vehicules as $v)
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-bus"></i>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700">
                    {{ ucfirst($v->statut) }}
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $v->marque }} {{ $v->modele }}</h3>
            <p class="text-sm font-mono text-gray-500 mb-4">{{ $v->immatriculation }}</p>
            <a href="{{ route('manager.vehicules.show', $v) }}" class="block text-center py-2 bg-gray-50 hover:bg-gray-100 text-sm font-semibold text-gray-700 rounded-lg transition">
                Détails
            </a>
        </div>
        @empty
        <div class="col-span-full p-8 text-center text-gray-500">Aucun véhicule enregistré.</div>
        @endforelse
    </div>
    
    @if($vehicules->hasPages())
    <div class="mt-4 shrink-0">            {{ $vehicules->links() }}        </div>
    @endif
</div>
@endsection
