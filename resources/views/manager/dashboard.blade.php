@extends('layouts.manager')

@section('content')
<style>
    /* Désactiver le scroll global sur le tableau de bord */
    html, body { overflow: hidden !important; height: 100vh !important; }
</style>
<div class="flex flex-col gap-4 h-[calc(100vh-140px)] overflow-hidden">

    {{-- ─── HEADER ─── --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-chart-pie text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Tableau de Bord Manager</h1>
                    <p class="text-purple-100 text-sm mt-1">Supervision globale de l'entreprise</p>
                </div>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white/15 rounded-xl backdrop-blur-sm border border-white/20">
                <div class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></div>
                <span class="text-xs text-white font-medium">Vue Globale Active</span>
            </div>
        </div>
    </div>

    {{-- ─── STATS CARDS ─── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 animate-fade-in-up" style="animation-delay:0.1s">

        {{-- Véhicules --}}
        <div class="card-hover rounded-2xl bg-white dark:bg-gray-800 p-5 shadow-sm border border-gray-100 dark:border-gray-700 cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Parc Automobile</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['vehicules'] ?? 0 }}</p>
                    <p class="text-xs text-blue-500 mt-0.5">Véhicules enregistrés</p>
                </div>
                <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-bus text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Chauffeurs --}}
        <div class="card-hover rounded-2xl bg-white dark:bg-gray-800 p-5 shadow-sm border border-gray-100 dark:border-gray-700 cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Effectif Chauffeurs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['chauffeurs'] ?? 0 }}</p>
                    <p class="text-xs text-yellow-500 mt-0.5">Collaborateurs</p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400">
                    <i class="fas fa-id-card text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Voyages --}}
        <div class="card-hover rounded-2xl bg-white dark:bg-gray-800 p-5 shadow-sm border border-gray-100 dark:border-gray-700 cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Voyages En Cours</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['voyages_en_cours'] ?? 0 }}</p>
                    <p class="text-xs text-orange-500 mt-0.5">Sur {{ $stats['voyages'] ?? 0 }} au total</p>
                </div>
                <div class="p-3 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
                    <i class="fas fa-route text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Finances --}}
        <div class="card-hover rounded-2xl bg-white dark:bg-gray-800 p-5 shadow-sm border border-gray-100 dark:border-gray-700 cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Chiffre d'Affaires</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['recettes_total'] ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-green-500 mt-0.5">Franc CFA cumulés</p>
                </div>
                <div class="p-3 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                    <i class="fas fa-coins text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── MODULES APERCU ─── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 flex-1 min-h-0 animate-fade-in-up" style="animation-delay:0.2s">

        {{-- DERNIERS VOYAGES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-400 to-orange-500 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <i class="fas fa-route text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Opérations Récentes</h2>
                            <p class="text-orange-100 text-xs">Derniers voyages</p>
                        </div>
                    </div>
                    <a href="{{ route('manager.voyages.index') }}" class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="p-0 overflow-y-auto h-[calc(100%-70px)] custom-scrollbar">
                <ul class="divide-y divide-gray-50 dark:divide-gray-700/50">
                    @forelse($derniers_voyages as $v)
                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    <i class="fas fa-map-marker-alt text-orange-400 text-xs mr-1"></i>
                                    {{ $v->destination }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $v->vehicule->immatriculation ?? 'N/A' }}
                                    &bull;
                                    {{ $v->chauffeur->nom ?? 'N/A' }} {{ $v->chauffeur->prenom ?? '' }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                {{ $v->date_depart->format('d/m/Y') }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="p-6 text-center text-gray-500"><p class="text-sm">Aucun voyage.</p></li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- DERNIERES MAINTENANCES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-500 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <i class="fas fa-tools text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Suivi Parc</h2>
                            <p class="text-amber-100 text-xs">Dernières maintenances</p>
                        </div>
                    </div>
                    <a href="{{ route('manager.maintenances.index') }}" class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="p-0 overflow-y-auto h-[calc(100%-70px)] custom-scrollbar">
                <ul class="divide-y divide-gray-50 dark:divide-gray-700/50">
                    @forelse($dernieres_maintenances as $m)
                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $m->vehicule->immatriculation ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Intervention {{ ucfirst($m->type) }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucfirst($m->statut) }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1">{{ $m->date_prevue->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="p-6 text-center text-gray-500"><p class="text-sm">Aucune maintenance.</p></li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>

</div>
@endsection
