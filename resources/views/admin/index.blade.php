@extends('layouts.app')

@section('content')
<style>
    /* Désactiver le scroll global sur le tableau de bord */
    html, body { overflow: hidden !important; height: 100vh !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
    
    /* Animations personnalisées */
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse-slow { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.6; transform: scale(1.05); } }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .backdrop-blur-xl { backdrop-filter: blur(20px); }
    * { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
</style>

<div class="flex flex-col gap-3 h-[calc(100vh-100px)] overflow-hidden pb-2">
    <!-- Header avec couleurs harmonisées -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-950/90 via-purple-950/90 to-pink-950/90 backdrop-blur-2xl border border-white/15 p-4 shadow-xl animate-slide-down shrink-0">
        <!-- Effets de fond avec couleurs douces -->
        <div class="absolute top-0 -right-32 w-72 h-72 bg-indigo-400/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 -left-32 w-72 h-72 bg-purple-400/20 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>

        <div class="relative flex justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="relative hidden sm:block">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-xl blur-lg"></div>
                    <div class="relative p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-white via-indigo-100 to-purple-200 bg-clip-text text-transparent">
                        Dashboard Admin
                    </h1>
                    <p class="text-gray-300 text-[10px] mt-0.5">Vue d'ensemble et statistiques en temps réel</p>
                </div>
            </div>
            
            @if($nb_alertes_maintenance_km > 0)
            <div class="flex items-center gap-2 px-4 py-2 bg-rose-500/20 border border-rose-500/30 rounded-xl animate-pulse">
                <i class="fas fa-tools text-rose-400 text-sm"></i>
                <span class="text-xs font-bold text-rose-200">{{ $nb_alertes_maintenance_km }} maintenance(s) à prévoir</span>
            </div>
            @endif

            <div class="hidden sm:flex items-center gap-2">
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/15 backdrop-blur-sm border border-emerald-500/25">
                    <div class="relative">
                        <span class="flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                        </span>
                    </div>
                    <span class="text-[10px] text-emerald-300 font-medium">Données en direct</span>
                </div>
                <div class="px-3 py-1.5 rounded-lg bg-white/5 backdrop-blur-sm border border-white/10">
                    <span class="text-[10px] text-gray-400">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des cartes statistiques avec couleurs harmonisées -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 shrink-0 animate-fade-in-up">

        <!-- Carte Véhicules - Bleu -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-blue-500/20 shadow-lg hover:shadow-blue-500/20 hover:border-blue-500/40 hover:-translate-y-1 transition-transform">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 via-blue-500/0 to-blue-500/0 group-hover:from-blue-500/15 group-hover:via-blue-500/5 group-hover:to-blue-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/30 transition-all duration-500"></div>

            <div class="relative p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            <circle cx="6" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <circle cx="18" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-semibold text-blue-400 bg-blue-500/15 px-2 py-0.5 rounded-full backdrop-blur-sm">Flotte</span>
                </div>

                <div>
                    <h3 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-0.5">Total Véhicules</h3>
                    <p class="text-2xl font-bold text-white">{{ $vehicules ?? 0 }}</p>
                </div>

                <div class="mt-2 pt-2 border-t border-white/10">
                    <div class="grid grid-cols-3 gap-1 text-center">
                        <div>
                            <div class="text-[9px] text-gray-500">Dispo</div>
                            <div class="text-[10px] font-semibold text-emerald-400">{{ $vehicules_disponibles ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-500">Mission</div>
                            <div class="text-[10px] font-semibold text-amber-400">{{ $vehicules_mission ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-500">Mainten.</div>
                            <div class="text-[10px] font-semibold text-rose-400">{{ $vehicules_maintenance ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-blue-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Chauffeurs - Émeraude -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-emerald-500/20 shadow-lg hover:shadow-emerald-500/20 hover:border-emerald-500/40 hover:-translate-y-1 transition-transform" style="animation-delay: 0.1s">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 via-emerald-500/0 to-emerald-500/0 group-hover:from-emerald-500/15 group-hover:via-emerald-500/5 group-hover:to-emerald-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all duration-500"></div>

            <div class="relative p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-[9px] font-semibold text-emerald-400 bg-emerald-500/15 px-2 py-0.5 rounded-full backdrop-blur-sm">Personnel</span>
                </div>

                <div>
                    <h3 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-0.5">Chauffeurs</h3>
                    <p class="text-2xl font-bold text-white">{{ $chauffeurs ?? 0 }}</p>
                </div>

                <div class="mt-2 pt-2 border-t border-white/10">
                    <div class="grid grid-cols-3 gap-1 text-center">
                        <div>
                            <div class="text-[9px] text-gray-500">Dispo</div>
                            <div class="text-[10px] font-semibold text-emerald-400">{{ $chauffeurs_disponibles ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-500">Mission</div>
                            <div class="text-[10px] font-semibold text-amber-400">{{ $chauffeurs_mission ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-500">Congé</div>
                            <div class="text-[10px] font-semibold text-gray-400">{{ $chauffeurs_conge ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-emerald-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Voyages - Ambre -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-amber-500/20 shadow-lg hover:shadow-amber-500/20 hover:border-amber-500/40 hover:-translate-y-1 transition-transform" style="animation-delay: 0.2s">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/0 via-amber-500/0 to-amber-500/0 group-hover:from-amber-500/15 group-hover:via-amber-500/5 group-hover:to-amber-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/30 transition-all duration-500"></div>

            <div class="relative p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-[9px] font-semibold text-amber-400 bg-amber-500/15 px-2 py-0.5 rounded-full backdrop-blur-sm">Trajets</span>
                </div>

                <div>
                    <h3 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-0.5">Voyages</h3>
                    <p class="text-2xl font-bold text-white">{{ $voyages ?? 0 }}</p>
                </div>

                <div class="mt-2 pt-2 border-t border-white/10">
                    <div class="grid grid-cols-2 gap-1 text-center">
                        <div>
                            <div class="text-[9px] text-gray-500">Ce mois</div>
                            <div class="text-[10px] font-semibold text-amber-400">{{ $voyages_mois ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-500">Total</div>
                            <div class="text-[10px] font-semibold text-white">{{ $voyages ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 via-amber-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>

        <!-- Carte Alertes - Rose -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-rose-500/20 shadow-lg hover:shadow-rose-500/20 hover:border-rose-500/40 hover:-translate-y-1 transition-transform" style="animation-delay: 0.3s">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/0 via-rose-500/0 to-rose-500/0 group-hover:from-rose-500/15 group-hover:via-rose-500/5 group-hover:to-rose-500/0 transition-all duration-700"></div>
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/30 transition-all duration-500"></div>

            <div class="relative p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            <circle cx="12" cy="17" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-semibold text-rose-400 bg-rose-500/15 px-2 py-0.5 rounded-full backdrop-blur-sm">Urgent</span>
                </div>

                <div>
                    <h3 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-0.5">Alertes</h3>
                    <p class="text-2xl font-bold {{ ($alertes ?? 0) > 0 ? 'text-rose-400 animate-pulse' : 'text-white' }}">{{ $alertes ?? 0 }}</p>
                </div>

                <div class="mt-2 pt-2 border-t border-white/10">
                    <div class="grid grid-cols-2 gap-1 text-center">
                        <div>
                            <div class="text-[9px] text-gray-500">Critiques</div>
                            <div class="text-[10px] font-semibold text-rose-400">{{ $alertes_critiques ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-500">Mineures</div>
                            <div class="text-[10px] font-semibold text-amber-400">{{ $alertes_mineures ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 via-rose-400 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
        </div>
    </div>

    <!-- Section Graphique avec couleurs harmonisées -->
    <div class="rounded-2xl bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl border border-white/10 p-4 shadow-xl flex-1 flex flex-col min-h-0 animate-fade-in-up" style="animation-delay: 0.6s">
        <div class="flex items-center justify-between shrink-0 mb-3">
            <div>
                <h2 class="text-sm font-semibold text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Évolution des Recettes
                </h2>
                <p class="text-[10px] text-gray-500 mt-0.5">Tendance mensuelle des recettes (12 derniers mois)</p>
            </div>
            <div class="flex gap-1.5">
                <button class="px-2 py-1 text-[10px] rounded bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 hover:bg-indigo-500/30 transition-all duration-300">
                    Mois
                </button>
                <button class="px-2 py-1 text-[10px] rounded bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10 transition-all duration-300">
                    Année
                </button>
            </div>
        </div>

        <div class="relative flex-1 min-h-0 w-full">
            <canvas id="statsChart"></canvas>
        </div>
    </div>

    @if($nb_alertes_maintenance_km > 0)
    <!-- Alertes Maintenance Kilométrage -->
    <div class="rounded-2xl bg-slate-900/90 backdrop-blur-xl border border-rose-500/20 p-4 shadow-xl shrink-0 animate-fade-in-up" style="animation-delay: 0.7s">
        <h2 class="text-sm font-bold text-rose-400 flex items-center gap-2 mb-3">
            <i class="fas fa-exclamation-triangle"></i>
            Maintenances à prévoir (Seuil 5000 km)
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($vehicules_alerte_km as $alerte)
            <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/10 group hover:bg-white/10 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-rose-500/10 flex items-center justify-center text-rose-400 group-hover:scale-110 transition-transform">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">{{ $alerte['immatriculation'] }}</p>
                        <p class="text-[10px] text-gray-400">Parcourus: <span class="text-rose-400 font-bold">{{ number_format($alerte['distance'], 0) }} km</span></p>
                    </div>
                </div>
                <a href="{{ route('admin.maintenances.create', ['vehicule_id' => $alerte['id']]) }}" class="px-3 py-1.5 bg-rose-500 text-white text-[10px] font-bold rounded-lg hover:bg-rose-600 transition-colors">
                    Planifier
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statsChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chart_labels),
                datasets: [{
                    label: 'Recettes',
                    data: @json($chart_data),
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                    barPercentage: 0.65,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 5 },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#9ca3af',
                            font: { size: 10, weight: '500' },
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
                        padding: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return `Recettes: ${context.raw.toLocaleString()} CFA`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                        ticks: { color: '#9ca3af', stepSize: 5, font: { size: 9 } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#9ca3af', font: { size: 9, weight: '500' } }
                    }
                },
                animation: { duration: 1500, easing: 'easeOutQuart' },
                hover: { mode: 'index', intersect: false, animationDuration: 200 },
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
