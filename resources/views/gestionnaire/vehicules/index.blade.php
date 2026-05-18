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

    <!-- Barre de recherche -->
    <div class="relative animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md">
            <form method="GET" class="relative flex items-center w-full">
                <button type="submit" class="pl-4 cursor-pointer text-gray-400 hover:text-indigo-500 transition-colors z-10" title="Rechercher">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <div class="flex-1">
                    <input type="text"
                           name="search"
                           placeholder="Rechercher par immatriculation, marque, modèle..."
                           value="{{ request('search') }}"
                           class="w-full p-3 bg-transparent text-gray-700 dark:text-gray-300 placeholder-gray-400 focus:outline-none">
                </div>
                @if(request('search'))
                <a href="{{ route($rolePrefix . '.vehicules.index') }}" class="pr-4">
                    <svg class="w-5 h-5 text-gray-400 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Statistiques rapides des véhicules -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.2s">
        <!-- Total Véhicules -->
        <div class="rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-100 uppercase tracking-wider">Total</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->total() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Disponibles -->
        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider">Disponibles</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->where('statut', 'disponible')->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- En mission -->
        <div class="rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-sky-100 uppercase tracking-wider">En mission</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->where('statut', 'mission')->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Maintenance -->
        <div class="rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider">Maintenance</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->where('statut', 'maintenance')->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
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
</script>
