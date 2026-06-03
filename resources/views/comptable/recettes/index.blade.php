@extends('layouts.comptable')

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
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-coins text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Recettes Mensuelles</h1>
                    <p class="text-emerald-100 text-sm mt-1">Gestion des revenus de la flotte</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('comptable.recettes.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-emerald-700 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-plus"></i> Nouvelle recette
                </a>
                <form method="GET" class="relative group">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/50 group-focus-within:text-white transition-colors z-10 cursor-pointer hover:opacity-80 transition-opacity">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                           class="w-64 pl-12 pr-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:bg-white/20 focus:ring-2 focus:ring-white/30 outline-none backdrop-blur-sm transition-all">
                </form>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 animate-fade-in-up" style="animation-delay:0.1s">
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider font-semibold">Total recettes</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($recettes_total, 0, ',', ' ') }}</p>
                    <p class="text-xs text-emerald-200">Franc CFA</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-coins text-white text-xl"></i></div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-teal-100 uppercase tracking-wider font-semibold">Moyenne mensuelle</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($recettes_avg ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-teal-200">Franc CFA / mois</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-chart-line text-white text-xl"></i></div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-cyan-100 uppercase tracking-wider font-semibold">Enregistrements</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $recettes_count }}</p>
                    <p class="text-xs text-cyan-200">au total</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-receipt text-white text-xl"></i></div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider font-semibold">Ce mois</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($recettes_mois_total ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-amber-200">Franc CFA</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-calendar-alt text-white text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 animate-fade-in-up flex flex-col flex-1 min-h-0" style="animation-delay:0.2s">
        <div class="shrink-0 px-6 py-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-750 dark:to-gray-800 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                    <i class="fas fa-list text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">Historique des recettes</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Liste détaillée des revenus</p>
                </div>
            </div>
            <a href="{{ route('comptable.recettes.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all duration-300">
                <i class="fas fa-plus"></i> Ajouter
            </a>
        </div>
        
        <div class="overflow-auto flex-1 min-h-0 custom-scrollbar">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 sticky top-0 z-10 shadow-sm">
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Mois / Date</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Type</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Voyage / Véhicule</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Montant</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($recettes as $recette)
                    <tr class="hover:bg-emerald-50/40 dark:hover:bg-emerald-900/10 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">
                                        {{ \Carbon\Carbon::parse($recette->mois ?? $recette->date)->isoFormat('MMMM YYYY') }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($recette->date ?? $recette->mois)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                {{ ($recette->type ?? '') === 'Billet'   ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                {{ ($recette->type ?? '') === 'Location' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : '' }}
                                {{ ($recette->type ?? '') === 'Fret'     ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300' : '' }}
                                {{ !in_array($recette->type ?? '', ['Billet','Location','Fret']) ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                {{ $recette->type ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800 dark:text-white">
                                    {{ optional($recette->voyage)->destination ?? '—' }}
                                </span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">
                                    {{ optional($recette->vehicule)->immatriculation ?? '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-base font-bold text-emerald-600 dark:text-emerald-400">
                                {{ number_format($recette->montant, 0, ',', ' ') }} Franc CFA
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('comptable.recettes.show', $recette) }}"
                                   class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-800/40 text-indigo-600 dark:text-indigo-400 transition hover:scale-110" title="Voir">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('comptable.recettes.edit', $recette) }}"
                                   class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-800/40 text-blue-600 dark:text-blue-400 transition hover:scale-110" title="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('comptable.recettes.destroy', $recette) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer cette recette ?')"
                                            class="p-2 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-800/40 text-red-600 dark:text-red-400 transition hover:scale-110" title="Supprimer">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-coins text-3xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <p class="text-base font-semibold text-gray-500 dark:text-gray-400">Aucune recette enregistrée</p>
                                <p class="text-sm">Commencez par ajouter la première recette</p>
                                <a href="{{ route('comptable.recettes.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all">
                                    <i class="fas fa-plus"></i> Ajouter une recette
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recettes->hasPages())
        <div class="shrink-0 border-t border-gray-100 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-750 rounded-b-2xl">
            {{ $recettes->links() }}
        </div>
        @endif
    </div>
</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection
