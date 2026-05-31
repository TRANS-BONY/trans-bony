@extends('layouts.gestionnaire')

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
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Gestion des Véhicules
                    </h1>
                    <p class="text-emerald-100 text-sm mt-1">Gérez la flotte automobile du parc</p>
                </div>
            </div>
            @can('gerer vehicules')
            <a href="{{ route($rolePrefix . '.vehicules.create') }}"
               class="group relative overflow-hidden px-6 py-3 bg-white text-emerald-600 rounded-xl shadow-lg hover:bg-emerald-50 transition-all duration-300 hover:scale-105">
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-bold">Ajouter un véhicule</span>
                </div>
            </a>
            @endcan
        </div>
    </div>

    <!-- Barre de recherche et Filtres -->
    <div class="relative animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-2">
            <form method="GET" action="{{ route($rolePrefix . '.vehicules.index') }}" class="flex flex-col md:flex-row gap-2">
                {{-- Recherche textuelle --}}
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full pl-12 pr-10 py-3.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm text-gray-700 dark:text-gray-200 placeholder-gray-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition-all shadow-sm group-hover:border-emerald-300"
                           placeholder="Rechercher par immatriculation, marque, modèle...">
                    @if(request('search') || request('statut'))
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <a href="{{ route($rolePrefix . '.vehicules.index') }}" class="text-gray-400 hover:text-red-500 transition-colors" title="Effacer les filtres">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Filtres par Statut (Chips) --}}
                <div class="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0 no-scrollbar">
                    <input type="hidden" name="statut" id="statut-filter" value="{{ request('statut') }}">
                    
                    <button type="button" onclick="filterStatut('')" 
                            class="whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition-all {{ !request('statut') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 dark:shadow-none' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 hover:bg-gray-200' }}">
                        Tous
                    </button>
                    <button type="button" onclick="filterStatut('disponible')" 
                            class="whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition-all {{ request('statut') == 'disponible' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200 dark:shadow-none' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 hover:bg-emerald-100' }}">
                        Disponibles
                    </button>
                    <button type="button" onclick="filterStatut('mission')" 
                            class="whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition-all {{ request('statut') == 'mission' ? 'bg-sky-500 text-white shadow-lg shadow-sky-200 dark:shadow-none' : 'bg-sky-50 dark:bg-sky-900/20 text-sky-600 hover:bg-sky-100' }}">
                        En mission
                    </button>
                    <button type="button" onclick="filterStatut('maintenance')" 
                            class="whitespace-nowrap px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition-all {{ request('statut') == 'maintenance' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200 dark:shadow-none' : 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 hover:bg-amber-100' }}">
                        Maintenance
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques rapides des véhicules -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.2s">
        <!-- Total Véhicules -->
        <button type="button" onclick="filterStatut('')" 
             class="text-left rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl {{ !request('statut') ? 'ring-2 ring-indigo-300 ring-offset-2' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-indigo-100 uppercase tracking-wider font-bold">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
            </div>
        </button>

        <!-- Disponibles -->
        <button type="button" onclick="filterStatut('disponible')" 
             class="text-left rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl {{ request('statut') == 'disponible' ? 'ring-2 ring-emerald-300 ring-offset-2' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-emerald-100 uppercase tracking-wider font-bold">Disponibles</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['disponible'] }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </button>

        <!-- En mission -->
        <button type="button" onclick="filterStatut('mission')" 
             class="text-left rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl {{ request('statut') == 'mission' ? 'ring-2 ring-sky-300 ring-offset-2' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-sky-100 uppercase tracking-wider font-bold">En mission</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['mission'] }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </div>
        </button>

        <!-- Maintenance -->
        <button type="button" onclick="filterStatut('maintenance')" 
             class="text-left rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl {{ request('statut') == 'maintenance' ? 'ring-2 ring-amber-300 ring-offset-2' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-amber-100 uppercase tracking-wider font-bold">Maintenance</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['maintenance'] }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </button>
    </div>

    <!-- Liste des véhicules (Tableau Desktop / Cartes Mobile) -->
    <div class="animate-fade-in-up" style="animation-delay: 0.3s">
        <style>
            .animate-fade-in-up[style*="0.3s"] { flex: 1; min-height: 0; display: flex; flex-direction: column; overflow: hidden; }
            .animate-fade-in-up[style*="0.3s"] > div { flex: 1; overflow-y: auto; }
        </style>
        {{-- Vue Mobile : Grille de Cartes (Cachée sur LG) --}}
        <div class="list-scroll-container custom-scrollbar grid grid-cols-1 md:grid-cols-2 gap-4 lg:hidden">
            @forelse($vehicules as $v)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all duration-300">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                                    <i class="fas fa-truck text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $v->immatriculation }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $v->marque }} {{ $v->modele }}</p>
                                </div>
                            </div>
                            @php
                                $statusConfig = [
                                    'disponible' => ['bg' => 'bg-emerald-500', 'text' => 'text-white', 'label' => 'Disponible'],
                                    'mission' => ['bg' => 'bg-sky-500', 'text' => 'text-white', 'label' => 'En mission'],
                                    'maintenance' => ['bg' => 'bg-amber-500', 'text' => 'text-white', 'label' => 'Maintenance']
                                ];
                                $config = $statusConfig[$v->statut] ?? $statusConfig['disponible'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }}">
                                {{ $config['label'] }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-3 border-t border-b border-gray-50 dark:border-gray-700/50 my-3">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-semibold">Année</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $v->annee }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-semibold">Capacité</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $v->capacite }} pers.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 mt-2">
                            <a href="{{ route($rolePrefix . '.vehicules.show', $v->id) }}" class="p-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('gerer vehicules')
                            <a href="{{ route($rolePrefix . '.vehicules.edit', $v->id) }}" class="p-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route($rolePrefix . '.vehicules.destroy', $v->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ce véhicule ?')" class="p-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-600">
                    <p class="text-gray-500">Aucun véhicule</p>
                </div>
            @endforelse
        </div>

        {{-- Vue Desktop : Tableau (Caché sur Mobile/Tablette) --}}
        <div class="hidden lg:block rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                            <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Immatriculation</th>
                            <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Marque / Modèle</th>
                            <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Année</th>
                            <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Capacité</th>
                            <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                            <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($vehicules as $v)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 group">
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                                        <i class="fas fa-truck text-indigo-600 dark:text-indigo-400 text-xs"></i>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $v->immatriculation }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700 dark:text-gray-300">
                                <div class="font-medium">{{ $v->marque }}</div>
                                <div class="text-xs text-gray-500">{{ $v->modele }}</div>
                            </td>
                            <td class="p-4 text-gray-700 dark:text-gray-300">{{ $v->annee }}</td>
                            <td class="p-4 text-gray-700 dark:text-gray-300">{{ $v->capacite }} pers.</td>
                            <td class="p-4">
                                @php
                                    $statusConfig = [
                                        'disponible' => ['bg' => 'bg-emerald-500', 'text' => 'text-white', 'icon' => 'fas fa-check-circle', 'label' => 'Disponible'],
                                        'mission' => ['bg' => 'bg-sky-500', 'text' => 'text-white', 'icon' => 'fas fa-paper-plane', 'label' => 'En mission'],
                                        'maintenance' => ['bg' => 'bg-amber-500', 'text' => 'text-white', 'icon' => 'fas fa-wrench', 'label' => 'Maintenance']
                                    ];
                                    $config = $statusConfig[$v->statut] ?? $statusConfig['disponible'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase {{ $config['bg'] }} {{ $config['text'] }}">
                                    <i class="{{ $config['icon'] }} text-[9px]"></i>
                                    {{ $config['label'] }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route($rolePrefix . '.vehicules.show', $v->id) }}" class="p-2 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-gray-400 hover:text-emerald-600 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('gerer vehicules')
                                    <a href="{{ route($rolePrefix . '.vehicules.edit', $v->id) }}" class="p-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-gray-400 hover:text-indigo-600 transition-all">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route($rolePrefix . '.vehicules.destroy', $v->id) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Supprimer ce véhicule ?')" class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 text-gray-400 hover:text-red-600 transition-all">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6 animate-fade-in-up" style="animation-delay: 0.4s">
        {{ $vehicules->links() }}
    </div>
</div>
@endsection

<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    tbody tr { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
    });

    function filterStatut(val) {
        document.getElementById('statut-filter').value = val;
        document.getElementById('statut-filter').form.submit();
    }
</script>
