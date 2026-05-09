@extends('layouts.technicien')

@section('content')
<div class="space-y-6">

    {{-- ─── HEADER ─── --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-red-600 to-amber-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-wrench text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Tableau de Bord Technicien</h1>
                    <p class="text-orange-100 text-sm mt-1">Supervision du parc et de la maintenance</p>
                </div>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white/15 rounded-xl backdrop-blur-sm border border-white/20">
                <div class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></div>
                <span class="text-xs text-white font-medium">Parc Actif</span>
            </div>
        </div>
    </div>

    {{-- ─── STATS CARDS ─── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 animate-fade-in-up" style="animation-delay:0.1s">

        {{-- Véhicules --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-5 shadow-lg cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-100 uppercase tracking-wider font-semibold">Total Véhicules</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $nb_vehicules ?? 0 }}</p>
                    <p class="text-xs text-blue-200 mt-0.5">Dans le parc</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-bus text-white text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Maintenances En Cours --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 p-5 shadow-lg cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-orange-100 uppercase tracking-wider font-semibold">En Cours</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $maintenances_en_cours ?? 0 }}</p>
                    <p class="text-xs text-orange-200 mt-0.5">Maintenances actives</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-tools text-white text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Maintenances Planifiées --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-500 p-5 shadow-lg cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider font-semibold">Planifiées</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $maintenances_planifiees ?? 0 }}</p>
                    <p class="text-xs text-amber-200 mt-0.5">À venir</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Maintenances Terminées --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 p-5 shadow-lg cursor-pointer" x-data="{ cardHover: false }" @mouseenter="cardHover = true" @mouseleave="cardHover = false" :class="cardHover ? 'floating shadow-2xl scale-[1.03] z-10' : ''" x-transition.duration.500ms>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-green-100 uppercase tracking-wider font-semibold">Terminées</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $maintenances_terminees ?? 0 }}</p>
                    <p class="text-xs text-green-200 mt-0.5">Historique global</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── MODULES ─── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up" style="animation-delay:0.2s">

        {{-- DERNIERES MAINTENANCES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <i class="fas fa-clipboard-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Dernières Maintenances</h2>
                            <p class="text-orange-100 text-xs">Interventions récentes</p>
                        </div>
                    </div>
                    <a href="{{ route('technicien.maintenances.index') }}"
                       class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Voir tout
                    </a>
                </div>
            </div>

            <div class="p-5">
                <div class="space-y-3 overflow-hidden max-h-[200px] custom-scrollbar pr-2">
                    @forelse($dernieres_maintenances ?? [] as $m)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-gray-700 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                                {{ $m->statut == 'terminee' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                                {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : '' }}">
                                <i class="fas fa-tools text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                    {{ $m->vehicule->immatriculation ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-400">{{ ucfirst($m->type) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-md font-semibold
                                {{ $m->statut == 'terminee' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                                {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}">
                                {{ ucfirst($m->statut) }}
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $m->date_prevue->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-6 text-gray-400">
                        <i class="fas fa-check-circle text-4xl mb-3 text-gray-200 dark:text-gray-600"></i>
                        <p class="text-sm">Aucune maintenance récente</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-4 flex gap-3">
                    <a href="{{ route('technicien.maintenances.create') }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                        <i class="fas fa-plus"></i> Nouvelle
                    </a>
                </div>
            </div>
        </div>

        {{-- ACCES RAPIDE VEHICULES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <i class="fas fa-bus text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Parc Automobile</h2>
                            <p class="text-blue-100 text-xs">Consultation rapide</p>
                        </div>
                    </div>
                    <a href="{{ route('technicien.vehicules.index') }}"
                       class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Voir le parc
                    </a>
                </div>
            </div>

            <div class="p-5 flex flex-col justify-center h-full min-h-[200px]">
                <div class="text-center space-y-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-500 dark:text-blue-400">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Consulter les véhicules</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Accédez aux fiches véhicules pour voir leur historique de maintenance, leur capacité et leur état actuel.
                    </p>
                    <a href="{{ route('technicien.vehicules.index') }}" class="inline-flex items-center justify-center gap-2 py-2.5 px-5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-xl transition">
                        <i class="fas fa-arrow-right"></i> Parcourir
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
