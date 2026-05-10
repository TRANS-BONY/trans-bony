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
    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Effectif Chauffeurs</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultation globale des chauffeurs</p>
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
        @forelse($chauffeurs as $c)
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                    <i class="fas fa-id-card"></i>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-lg
                    {{ $c->actif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $c->actif ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $c->nom }} {{ $c->prenom }}</h3>
            <p class="text-sm text-gray-500 mb-1">{{ $c->telephone }}</p>
            <p class="text-xs font-mono text-gray-400 mb-4">Permis: {{ $c->permis }}</p>
            <a href="{{ route('manager.chauffeurs.show', $c) }}" class="block text-center py-2 bg-gray-50 hover:bg-gray-100 text-sm font-semibold text-gray-700 rounded-lg transition">
                Détails
            </a>
        </div>
        @empty
        <div class="col-span-full p-8 text-center text-gray-500">Aucun chauffeur enregistré.</div>
        @endforelse
    </div>
    
    @if($chauffeurs->hasPages())
    <div class="mt-4 shrink-0">            {{ $chauffeurs->links() }}        </div>
    @endif
</div>
@endsection
