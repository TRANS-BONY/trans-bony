@extends('layouts.app')

@section('content')
<div class="min-h-screen pb-8">
    <!-- Header avec couleurs harmonisées -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-950/90 via-purple-950/90 to-pink-950/90 backdrop-blur-2xl border border-white/15 p-8 mb-8 shadow-2xl animate-slide-down">
        <!-- Effets de fond avec couleurs douces -->
        <div class="absolute top-0 -right-32 w-72 h-72 bg-indigo-400/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 -left-32 w-72 h-72 bg-purple-400/20 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-2xl blur-lg"></div>
                    <div class="relative p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white via-indigo-100 to-purple-200 bg-clip-text text-transparent">
                        Dashboard Admin
                    </h1>
                    <p class="text-gray-300 text-sm mt-1">Vue d'ensemble et statistiques en temps réel</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/15 backdrop-blur-sm border border-emerald-500/25">
                    <div class="relative">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                    </div>
                    <span class="text-xs text-emerald-300 font-medium">Données en direct</span>
                </div>
                <div class="px-4 py-2 rounded-full bg-white/5 backdrop-blur-sm border border-white/10">
                    <span class="text-xs text-gray-400">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des cartes statistiques avec couleurs harmonisées -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">

        <!-- Carte Véhicules - Bleu -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-blue-500/20 shadow-xl transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/20 hover:border-blue-500/40 hover:-translate-y-2 animate-fade-in-up">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 via-blue-500/0 to-blue-500/0 group-hover:from-blue-500/15 group-hover:via-blue-500/5 group-hover:to-blue-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/30 transition-all duration-500"></div>

            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                <circle cx="6" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <circle cx="18" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-blue-400 bg-blue-500/15 px-3 py-1 rounded-full backdrop-blur-sm">Flotte</span>
                    </div>
                </div>

                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-1">Total Véhicules</h3>
                    <p class="text-4xl font-bold text-white">{{ $vehicules ?? 0 }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-xs text-emerald-400">+12%</span>
                        </div>
                        <span class="text-xs text-gray-500">vs mois dernier</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div>
                            <div class="text-xs text-gray-500">Dispo</div>
                            <div class="text-sm font-semibold text-emerald-400">{{ $vehicules_disponibles ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Mission</div>
                            <div class="text-sm font-semibold text-amber-400">{{ $vehicules_mission ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Mainten.</div>
                            <div class="text-sm font-semibold text-rose-400">{{ $vehicules_maintenance ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-blue-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Chauffeurs - Émeraude -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-emerald-500/20 shadow-xl transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/20 hover:border-emerald-500/40 hover:-translate-y-2 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 via-emerald-500/0 to-emerald-500/0 group-hover:from-emerald-500/15 group-hover:via-emerald-500/5 group-hover:to-emerald-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all duration-500"></div>

            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-emerald-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9l2 2 4-4" stroke="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-emerald-400 bg-emerald-500/15 px-3 py-1 rounded-full backdrop-blur-sm">Personnel</span>
                    </div>
                </div>

                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-1">Chauffeurs</h3>
                    <p class="text-4xl font-bold text-white">{{ $chauffeurs ?? 0 }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-xs text-emerald-400">+8%</span>
                        </div>
                        <span class="text-xs text-gray-500">vs mois dernier</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div>
                            <div class="text-xs text-gray-500">Dispo</div>
                            <div class="text-sm font-semibold text-emerald-400">{{ $chauffeurs_disponibles ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Mission</div>
                            <div class="text-sm font-semibold text-amber-400">{{ $chauffeurs_mission ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Congé</div>
                            <div class="text-sm font-semibold text-gray-400">{{ $chauffeurs_conge ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-emerald-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Voyages - Ambre -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-amber-500/20 shadow-xl transition-all duration-500 hover:shadow-2xl hover:shadow-amber-500/20 hover:border-amber-500/40 hover:-translate-y-2 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/0 via-amber-500/0 to-amber-500/0 group-hover:from-amber-500/15 group-hover:via-amber-500/5 group-hover:to-amber-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/30 transition-all duration-500"></div>

            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-amber-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7l5 5m0 0l-5 5m5-5H6" stroke="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-amber-400 bg-amber-500/15 px-3 py-1 rounded-full backdrop-blur-sm">Trajets</span>
                    </div>
                </div>

                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-1">Voyages</h3>
                    <p class="text-4xl font-bold text-white">{{ $voyages ?? 0 }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-xs text-emerald-400">+23%</span>
                        </div>
                        <span class="text-xs text-gray-500">vs mois dernier</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="grid grid-cols-2 gap-2 text-center">
                        <div>
                            <div class="text-xs text-gray-500">Ce mois</div>
                            <div class="text-sm font-semibold text-amber-400">{{ $voyages_mois ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Total</div>
                            <div class="text-sm font-semibold text-white">{{ $voyages ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 via-amber-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Alertes - Rose -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-rose-500/20 shadow-xl transition-all duration-500 hover:shadow-2xl hover:shadow-rose-500/20 hover:border-rose-500/40 hover:-translate-y-2 animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/0 via-rose-500/0 to-rose-500/0 group-hover:from-rose-500/15 group-hover:via-rose-500/5 group-hover:to-rose-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/30 transition-all duration-500"></div>

            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-rose-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                <circle cx="12" cy="17" r="1" fill="currentColor" stroke="none"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-rose-400 bg-rose-500/15 px-3 py-1 rounded-full backdrop-blur-sm">Urgent</span>
                    </div>
                </div>

                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-1">Alertes</h3>
                    <p class="text-4xl font-bold {{ ($alertes ?? 0) > 0 ? 'text-rose-400 animate-pulse' : 'text-white' }}">{{ $alertes ?? 0 }}</p>
                    @if(($alertes ?? 0) > 0)
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-rose-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs text-rose-400">Action requise</span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="grid grid-cols-2 gap-2 text-center">
                        <div>
                            <div class="text-xs text-gray-500">Critiques</div>
                            <div class="text-sm font-semibold text-rose-400">{{ $alertes_critiques ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Mineures</div>
                            <div class="text-sm font-semibold text-amber-400">{{ $alertes_mineures ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 via-rose-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>

            @if(($alertes ?? 0) > 0)
            <div class="absolute top-4 right-4">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                </span>
            </div>
            @endif
        </div>

        <!-- Carte Documents - Violet -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-violet-500/20 shadow-xl transition-all duration-500 hover:shadow-2xl hover:shadow-violet-500/20 hover:border-violet-500/40 hover:-translate-y-2 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-500/0 via-violet-500/0 to-violet-500/0 group-hover:from-violet-500/15 group-hover:via-violet-500/5 group-hover:to-violet-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/10 rounded-full blur-2xl group-hover:bg-violet-500/30 transition-all duration-500"></div>

            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-violet-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 2v4h4" stroke="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-violet-400 bg-violet-500/15 px-3 py-1 rounded-full backdrop-blur-sm">Archives</span>
                    </div>
                </div>

                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-1">Documents</h3>
                    <p class="text-4xl font-bold text-white">{{ $documents ?? 0 }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs text-emerald-400">{{ $docs_valides ?? 0 }} valides</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="grid grid-cols-2 gap-2 text-center">
                        <div>
                            <div class="text-xs text-gray-500">Bientôt exp.</div>
                            <div class="text-sm font-semibold text-amber-400">{{ $docs_bientot ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Expirés</div>
                            <div class="text-sm font-semibold text-rose-400">{{ $docs_expire ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-violet-500 via-violet-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Recette Mensuelle - Émeraude -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-emerald-500/20 shadow-xl transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/20 hover:border-emerald-500/40 hover:-translate-y-2 animate-fade-in-up" style="animation-delay: 0.5s">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 via-emerald-500/0 to-emerald-500/0 group-hover:from-emerald-500/15 group-hover:via-emerald-500/5 group-hover:to-emerald-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all duration-500"></div>

            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-emerald-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7l5 5m0 0l-5 5m5-5H6" stroke="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-emerald-400 bg-emerald-500/15 px-3 py-1 rounded-full backdrop-blur-sm">CA</span>
                    </div>
                </div>

                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-1">Recette Mensuelle</h3>
                    <p class="text-3xl font-bold text-emerald-400">{{ number_format($recettes ?? 0) }} <span class="text-base">FCFA</span></p>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-xs text-emerald-400 font-semibold">+15%</span>
                        </div>
                        <span class="text-xs text-gray-500">vs mois précédent</span>
                    </div>
                    <div class="mt-3">
                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full w-[68%] bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-emerald-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>
    </div>

    <!-- Section Graphique avec couleurs harmonisées -->
    <div class="rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-white/10 p-6 shadow-xl animate-fade-in-up" style="animation-delay: 0.6s">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Évolution des Activités
                </h2>
                <p class="text-sm text-gray-500 mt-1">Tendance mensuelle des opérations (Janvier - Mai)</p>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-xs rounded-lg bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 hover:bg-indigo-500/30 transition-all duration-300">
                    Mois
                </button>
                <button class="px-4 py-2 text-xs rounded-lg bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10 transition-all duration-300">
                    Année
                </button>
            </div>
        </div>

        <div class="relative" style="height: 350px;">
            <canvas id="statsChart"></canvas>
        </div>

        <!-- Légende des données avec couleurs harmonisées -->
        <div class="grid grid-cols-5 gap-4 mt-6 pt-4 border-t border-white/10">
            <div class="text-center">
                <div class="text-xs text-gray-500 mb-1">Janvier</div>
                <div class="text-lg font-bold text-white">10</div>
                <div class="h-1 w-full bg-indigo-500/30 rounded-full mt-1">
                    <div class="h-full w-[40%] bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full"></div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs text-gray-500 mb-1">Février</div>
                <div class="text-lg font-bold text-white">20</div>
                <div class="h-1 w-full bg-indigo-500/30 rounded-full mt-1">
                    <div class="h-full w-[80%] bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full"></div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs text-gray-500 mb-1">Mars</div>
                <div class="text-lg font-bold text-white">15</div>
                <div class="h-1 w-full bg-indigo-500/30 rounded-full mt-1">
                    <div class="h-full w-[60%] bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full"></div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs text-gray-500 mb-1">Avril</div>
                <div class="text-lg font-bold text-white">30</div>
                <div class="h-1 w-full bg-indigo-500/30 rounded-full mt-1">
                    <div class="h-full w-full bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full"></div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-xs text-gray-500 mb-1">Mai</div>
                <div class="text-lg font-bold text-white">25</div>
                <div class="h-1 w-full bg-indigo-500/30 rounded-full mt-1">
                    <div class="h-full w-[83%] bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.3;
            transform: scale(1);
        }
        50% {
            opacity: 0.6;
            transform: scale(1.05);
        }
    }

    .animate-slide-down {
        animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-pulse-slow {
        animation: pulse-slow 4s ease-in-out infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    /* Effet de glassmorphisme amélioré */
    .backdrop-blur-xl {
        backdrop-filter: blur(20px);
    }

    /* Transition smooth pour toutes les propriétés */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Scrollbar personnalisée */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statsChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai'],
                datasets: [{
                    label: 'Activités',
                    data: [10, 20, 15, 30, 25],
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.65,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#9ca3af',
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#e5e7eb',
                        borderColor: '#6366f1',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return `Activités: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            stepSize: 5,
                            font: {
                                size: 11
                            }
                        },
                        title: {
                            display: true,
                            text: 'Nombre d\'activités',
                            color: '#9ca3af',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Mois',
                            color: '#9ca3af',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                hover: {
                    mode: 'index',
                    intersect: false,
                    animationDuration: 200
                },
                elements: {
                    bar: {
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        hoverBackgroundColor: 'rgba(99, 102, 241, 1)',
                        borderSkipped: 'round'
                    }
                }
            }
        });
    });
</script>

@endsection
