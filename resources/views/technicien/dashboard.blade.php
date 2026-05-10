@extends('layouts.technicien')

@section('content')
<style>
    /* Désactiver le scroll global sur le tableau de bord */
    html, body { overflow: hidden !important; height: 100vh !important; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
</style>

<div class="flex flex-col gap-3 h-[calc(100vh-100px)] overflow-hidden pb-2">

    {{-- ─── HEADER ─── --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-red-600 to-amber-600 p-4 animate-slide-down shadow-xl shrink-0">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative flex justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm hidden sm:block">
                    <i class="fas fa-wrench text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Tableau de Bord Technicien</h1>
                    <p class="text-orange-100 text-xs mt-0.5">Supervision du parc et de la maintenance</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/15 rounded-xl backdrop-blur-sm border border-white/20">
                <div class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></div>
                <span class="text-xs text-white font-medium">Parc Actif</span>
            </div>
        </div>
    </div>

    {{-- ─── STATS CARDS ─── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 animate-fade-in-up shrink-0" style="animation-delay:0.1s">

        {{-- Véhicules --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Total Véhicules</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-bus text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ $nb_vehicules ?? 0 }}</p>
            <p class="text-[10px] text-blue-200 mt-1">Dans le parc</p>
        </div>

        {{-- Maintenances En Cours --}}
        <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-orange-100 uppercase tracking-wider font-semibold">En Cours</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-tools text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ $maintenances_en_cours ?? 0 }}</p>
            <p class="text-[10px] text-orange-200 mt-1">Maintenances actives</p>
        </div>

        {{-- Maintenances Planifiées --}}
        <div class="rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-500 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-amber-100 uppercase tracking-wider font-semibold">Planifiées</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ $maintenances_planifiees ?? 0 }}</p>
            <p class="text-[10px] text-amber-200 mt-1">À venir</p>
        </div>

        {{-- Maintenances Terminées --}}
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-green-100 uppercase tracking-wider font-semibold">Terminées</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ $maintenances_terminees ?? 0 }}</p>
            <p class="text-[10px] text-green-200 mt-1">Historique global</p>
        </div>
    </div>

    {{-- ─── MODULES ─── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 flex-1 min-h-0 animate-fade-in-up" style="animation-delay:0.2s">

        {{-- DERNIERES MAINTENANCES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 flex flex-col min-h-0">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 p-3 shrink-0 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-white/20 rounded-lg">
                            <i class="fas fa-clipboard-list text-white text-sm"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white">Dernières Maintenances</h2>
                    </div>
                    <a href="{{ route('technicien.maintenances.index') }}" class="text-[10px] bg-white/20 hover:bg-white/30 text-white px-2 py-1 rounded transition font-medium">Voir tout</a>
                </div>
            </div>

            <div class="p-3 flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2">
                @forelse($dernieres_maintenances ?? [] as $m)
                <div class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-gray-700 last:border-0 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center
                            {{ $m->statut == 'terminee' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' : '' }}
                            {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                            {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : '' }}">
                            <i class="fas fa-tools text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-white">
                                {{ $m->vehicule->immatriculation ?? 'N/A' }}
                            </p>
                            <p class="text-[10px] text-gray-400">{{ ucfirst($m->type) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold
                            {{ $m->statut == 'terminee' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                            {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                            {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}">
                            {{ ucfirst($m->statut) }}
                        </span>
                        <p class="text-[10px] text-gray-500 mt-1">{{ $m->date_prevue->format('d/m/Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center flex-1 text-gray-400">
                    <i class="fas fa-check-circle text-2xl mb-1 text-gray-200 dark:text-gray-600"></i>
                    <p class="text-[10px]">Aucune maintenance récente</p>
                </div>
                @endforelse
            </div>
            <div class="p-3 shrink-0 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('technicien.maintenances.create') }}" class="flex w-full items-center justify-center gap-1 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                    <i class="fas fa-plus"></i> Nouvelle intervention
                </a>
            </div>
        </div>

        {{-- ACCES RAPIDE VEHICULES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 flex flex-col min-h-0">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 shrink-0 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-white/20 rounded-lg">
                            <i class="fas fa-bus text-white text-sm"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white">Parc Automobile</h2>
                    </div>
                    <a href="{{ route('technicien.vehicules.index') }}" class="text-[10px] bg-white/20 hover:bg-white/30 text-white px-2 py-1 rounded transition font-medium">Voir le parc</a>
                </div>
            </div>

            <div class="p-4 flex-1 flex flex-col items-center justify-center text-center space-y-3">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-500 dark:text-blue-400">
                    <i class="fas fa-search text-xl"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Consulter les véhicules</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs">
                    Accédez aux fiches véhicules pour voir leur historique de maintenance et leur état actuel.
                </p>
                <a href="{{ route('technicien.vehicules.index') }}" class="inline-flex items-center justify-center gap-2 py-2 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-lg transition">
                    <i class="fas fa-arrow-right"></i> Parcourir
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
