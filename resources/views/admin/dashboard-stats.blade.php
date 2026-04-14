@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header with Animation -->
    <div class="animate-fade-in-down">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">Admin Dashboard</h1>
        <p class="text-gray-400 mt-1">Vue d'ensemble de l'activité et des statistiques</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1: Véhicules par Statut -->
        <div class="group relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 p-6 shadow-xl transition-all duration-300 hover:scale-105 hover:bg-white/10 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-200">🚗 Véhicules par Statut</h3>
                    <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Disponibles</span>
                        <span class="text-2xl font-bold text-green-400">{{ $vehicules_disponibles ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Maintenance</span>
                        <span class="text-2xl font-bold text-yellow-400">{{ $vehicules_maintenance ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Mission</span>
                        <span class="text-2xl font-bold text-blue-400">{{ $vehicules_mission ?? 0 }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total</span>
                        <span class="font-semibold text-white">{{ ($vehicules_disponibles ?? 0) + ($vehicules_maintenance ?? 0) + ($vehicules_mission ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Documents Expirant -->
        <div class="group relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 p-6 shadow-xl transition-all duration-300 hover:scale-105 hover:bg-white/10 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl group-hover:bg-orange-500/20 transition-all duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-200">📄 Documents Expirant</h3>
                    <div class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 rounded-lg bg-yellow-500/10 border border-yellow-500/20">
                        <span class="text-gray-300">⚠️ Bientôt expirés</span>
                        <span class="text-2xl font-bold text-orange-400">{{ $docs_bientot ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 rounded-lg bg-red-500/10 border border-red-500/20">
                        <span class="text-gray-300">❌ Expirés</span>
                        <span class="text-2xl font-bold text-red-400">{{ $docs_expire ?? 0 }}</span>
                    </div>
                </div>
                @if(($docs_bientot ?? 0) > 0 || ($docs_expire ?? 0) > 0)
                <div class="mt-4">
                    <span class="inline-flex items-center gap-1 text-xs text-red-400 animate-pulse">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        Action requise
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Card 3: Finances Mensuelles -->
        <div class="group relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 p-6 shadow-xl transition-all duration-300 hover:scale-105 hover:bg-white/10 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-all duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-200">💰 Finances Mensuelles</h3>
                    <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center py-2">
                    <p class="text-4xl font-bold text-green-400">{{ number_format($recette_mensuelle ?? 0) }} <span class="text-lg">FCFA</span></p>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="inline-flex items-center text-sm text-green-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +15%
                        </span>
                        <span class="text-xs text-gray-500">vs mois précédent</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10">
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full w-[65%] bg-gradient-to-r from-green-400 to-emerald-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Doughnut Chart -->
        <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-200">📊 Répartition Globale</h3>
                <div class="flex gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                </div>
            </div>
            <div class="relative" style="height: 280px;">
                <canvas id="statsChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-3 mt-4 pt-3 border-t border-white/10">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-400">Véhicules</span>
                    <span class="text-sm font-bold text-white ml-auto">{{ $vehicules ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span class="text-sm text-gray-400">Chauffeurs</span>
                    <span class="text-sm font-bold text-white ml-auto">{{ $chauffeurs ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <span class="text-sm text-gray-400">Voyages</span>
                    <span class="text-sm font-bold text-white ml-auto">{{ $voyages ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                    <span class="text-sm text-gray-400">Maintenances</span>
                    <span class="text-sm font-bold text-white ml-auto">{{ $maintenances ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Bar Chart Preview / Additional Stats -->
        <div class="relative overflow-hidden rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.5s">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-200">📈 Évolution Mensuelle</h3>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    <span>Activité récente</span>
                </div>
            </div>
            <div class="space-y-4">
                @php
                    $items = [
                        ['name' => 'Voyages', 'value' => $voyages ?? 0, 'color' => 'from-amber-500 to-orange-500'],
                        ['name' => 'Maintenances', 'value' => $maintenances ?? 0, 'color' => 'from-rose-500 to-pink-500'],
                        ['name' => 'Véhicules actifs', 'value' => ($vehicules_disponibles ?? 0) + ($vehicules_mission ?? 0), 'color' => 'from-blue-500 to-cyan-500'],
                    ];
                @endphp
                @foreach($items as $item)
                <div class="group">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-400">{{ $item['name'] }}</span>
                        <span class="font-semibold text-white">{{ $item['value'] }}</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                        @php
                            $maxValue = max(array_column($items, 'value')) ?: 1;
                            $percentage = ($item['value'] / $maxValue) * 100;
                        @endphp
                        <div class="h-full bg-gradient-to-r {{ $item['color'] }} rounded-full transition-all duration-1000 ease-out transform translate-x-0"
                             style="width: {{ $percentage }}%;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6 pt-4 border-t border-white/10">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Taux d'utilisation</span>
                    <span class="text-sm font-semibold text-green-400">
                        @php
                            $totalVehicules = ($vehicules_disponibles ?? 0) + ($vehicules_maintenance ?? 0) + ($vehicules_mission ?? 0);
                            $usageRate = $totalVehicules > 0 ? (($vehicules_mission ?? 0) / $totalVehicules) * 100 : 0;
                        @endphp
                        {{ number_format($usageRate, 1) }}%
                    </span>
                </div>
                <div class="h-1.5 bg-white/10 rounded-full mt-2 overflow-hidden">
                    <div class="h-full w-[{{ $usageRate }}%] bg-gradient-to-r from-green-400 to-emerald-500 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.6s">
        <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:scale-105">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center group-hover:bg-blue-500/40 transition-all">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="text-xs text-gray-300">Ajouter véhicule</span>
        </a>
        <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:scale-105">
            <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500/40 transition-all">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <span class="text-xs text-gray-300">Nouveau rapport</span>
        </a>
        <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:scale-105">
            <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/40 transition-all">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <span class="text-xs text-gray-300">Voir statistiques</span>
        </a>
        <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:scale-105">
            <div class="w-10 h-10 rounded-full bg-rose-500/20 flex items-center justify-center group-hover:bg-rose-500/40 transition-all">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <span class="text-xs text-gray-300">Alertes</span>
        </a>
    </div>
</div>

<!-- Custom Animations -->
<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.6s ease-out forwards;
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Smooth scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
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
            type: 'doughnut',
            data: {
                labels: ['Véhicules', 'Chauffeurs', 'Voyages', 'Maintenances'],
                datasets: [{
                    data: [{{ $vehicules ?? 0 }}, {{ $chauffeurs ?? 0 }}, {{ $voyages ?? 0 }}, {{ $maintenances ?? 0 }}],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 10,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#ccc',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    });
</script>
@endsection
