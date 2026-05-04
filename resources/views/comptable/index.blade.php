@extends('layouts.comptable')

@section('content')
<div class="space-y-6">

    {{-- ─── HEADER ─── --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-calculator text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Tableau de Bord Comptable</h1>
                    <p class="text-emerald-100 text-sm mt-1">Bienvenue, <span class="font-semibold">{{ auth()->user()->name }}</span> — {{ now()->isoFormat('dddd D MMMM YYYY') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white/15 rounded-xl backdrop-blur-sm border border-white/20">
                <div class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></div>
                <span class="text-xs text-white font-medium">Année {{ date('Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ─── STATS CARDS ─── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 animate-fade-in-up" style="animation-delay:0.1s">

        {{-- Recettes du mois --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-5 shadow-lg cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider font-semibold">Recettes du mois</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($recettes_mois ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-emerald-200 mt-0.5">Franc CFA</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-coins text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/20 flex items-center gap-2">
                @if(($recettes_evolution ?? 0) > 0)
                    <i class="fas fa-arrow-up text-xs text-emerald-200"></i>
                    <span class="text-xs text-emerald-100">+{{ $recettes_evolution }}% vs mois précédent</span>
                @elseif(($recettes_evolution ?? 0) < 0)
                    <i class="fas fa-arrow-down text-xs text-red-300"></i>
                    <span class="text-xs text-emerald-100">{{ $recettes_evolution }}% vs mois précédent</span>
                @else
                    <span class="text-xs text-emerald-100">{{ now()->format('F Y') }}</span>
                @endif
            </div>
        </div>

        {{-- Total recettes --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 p-5 shadow-lg cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-teal-100 uppercase tracking-wider font-semibold">Total recettes</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($recettes_total ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-teal-200 mt-0.5">Franc CFA cumulés</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/20">
                <div class="w-full bg-white/20 rounded-full h-1.5">
                    <div class="bg-white rounded-full h-1.5 transition-all duration-700" style="width: {{ min(100, $recettes_pct ?? 0) }}%"></div>
                </div>
                <p class="text-xs text-teal-100 mt-1">{{ $recettes_pct ?? 0 }}% de l'objectif</p>
            </div>
        </div>

        {{-- Nombre de recettes --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 p-5 shadow-lg cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-cyan-100 uppercase tracking-wider font-semibold">Nb. Recettes</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $nb_recettes ?? 0 }}</p>
                    <p class="text-xs text-cyan-200 mt-0.5">Enregistrements</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/20">
                <span class="text-xs text-cyan-100">{{ $nb_recettes_mois ?? 0 }} ce mois-ci</span>
            </div>
        </div>

        {{-- Rapports --}}
        <div class="card-hover rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 p-5 shadow-lg cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-100 uppercase tracking-wider font-semibold">Rapports</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $nb_rapports ?? 0 }}</p>
                    <p class="text-xs text-indigo-200 mt-0.5">Générés</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-chart-bar text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/20">
                <span class="text-xs text-indigo-100">Exports PDF & Excel disponibles</span>
            </div>
        </div>
    </div>

    {{-- ─── MODULES ─── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up" style="animation-delay:0.2s">

        {{-- MODULE RECETTES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <i class="fas fa-coins text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Recettes Mensuelles</h2>
                            <p class="text-emerald-100 text-xs">Dernières saisies</p>
                        </div>
                    </div>
                    <a href="{{ route('comptable.recettes.index') }}"
                       class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Voir tout
                    </a>
                </div>
            </div>

            <div class="p-5">
                @forelse($dernieres_recettes ?? [] as $recette)
                <div class="flex items-center justify-between py-3 border-b border-gray-50 dark:border-gray-700 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar text-emerald-600 dark:text-emerald-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($recette->mois ?? $recette->date)->isoFormat('MMMM YYYY') }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $recette->type ?? 'Recette' }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                        {{ number_format($recette->montant, 0, ',', ' ') }} Franc CFA
                    </span>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-200 dark:text-gray-600"></i>
                    <p class="text-sm">Aucune recette enregistrée</p>
                </div>
                @endforelse

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a href="{{ route('comptable.recettes.create') }}"
                       class="flex items-center justify-center gap-2 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition hover:scale-105 shadow-sm">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                    <a href="{{ route('comptable.recettes.index') }}"
                       class="flex items-center justify-center gap-2 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-xl transition hover:scale-105">
                        <i class="fas fa-list"></i> Liste
                    </a>
                </div>
            </div>
        </div>

        {{-- MODULE RAPPORTS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <i class="fas fa-chart-bar text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Rapports</h2>
                            <p class="text-indigo-100 text-xs">Statistiques & exports</p>
                        </div>
                    </div>
                    <a href="{{ route('comptable.rapports.index') }}"
                       class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition font-medium">
                        Ouvrir
                    </a>
                </div>
            </div>

            <div class="p-5 space-y-4">
                {{-- Stats rapide --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $vehicules ?? 0 }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Véhicules</p>
                    </div>
                    <div class="text-center p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                        <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $voyages ?? 0 }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Voyages</p>
                    </div>
                    <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $chauffeurs ?? 0 }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Chauffeurs</p>
                    </div>
                </div>

                {{-- Export rapide --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Export rapide</p>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('comptable.rapports.pdf') }}"
                           class="flex items-center justify-center gap-2 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition hover:scale-105 shadow-sm">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('comptable.rapports.excel') }}"
                           class="flex items-center justify-center gap-2 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition hover:scale-105 shadow-sm">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>

                <a href="{{ route('comptable.rapports.index') }}"
                   class="flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-sm font-semibold rounded-xl transition hover:scale-105 shadow-md w-full">
                    <i class="fas fa-external-link-alt"></i> Accéder aux rapports complets
                </a>
            </div>
        </div>
    </div>

    {{-- ─── GRAPHIQUE EVOLUTION DES RECETTES ─── --}}
    @if(isset($chart_labels) && count($chart_labels) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 animate-fade-in-up border border-gray-100 dark:border-gray-700" style="animation-delay:0.3s">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                    <i class="fas fa-chart-area text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">Évolution des Recettes</h2>
                    <p class="text-xs text-gray-400">12 derniers mois</p>
                </div>
            </div>
        </div>
        <canvas id="evolutionChart" height="100"></canvas>
    </div>
    @endif

</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>

@if(isset($chart_labels) && count($chart_labels) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('evolutionChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($chart_labels),
            datasets: [{
                label: 'Recettes (Franc CFA)',
                data: @json($chart_data),
                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                borderColor: '#10b981',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }, {
                label: 'Tendance',
                data: @json($chart_data),
                type: 'line',
                borderColor: '#6366f1',
                borderWidth: 2,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { labels: { color: '#6b7280', font: { size: 12 } } },
                tooltip: {
                    backgroundColor: 'rgba(17,24,39,0.9)',
                    titleColor: '#fff',
                    bodyColor: '#d1fae5',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    callbacks: { label: ctx => ` ${ctx.raw.toLocaleString('fr-FR')} Franc CFA` }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#9ca3af', callback: v => v.toLocaleString('fr-FR') } },
                x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
            },
            animation: { duration: 1200, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endif

@endsection
