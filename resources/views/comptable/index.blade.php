@extends('layouts.comptable')

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
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-4 animate-slide-down shadow-xl shrink-0">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative flex justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm hidden sm:block">
                    <i class="fas fa-calculator text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Tableau de Bord Comptable</h1>
                    <p class="text-emerald-100 text-xs mt-0.5">Bienvenue, <span class="font-semibold">{{ auth()->user()->name }}</span> — {{ now()->isoFormat('dddd D MMMM YYYY') }}</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/15 rounded-xl backdrop-blur-sm border border-white/20">
                <div class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></div>
                <span class="text-xs text-white font-medium">Année {{ date('Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Section Performance Financière (Contraste Amélioré) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 shrink-0 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Recettes -->
        <div class="p-4 rounded-2xl bg-emerald-100 border-2 border-emerald-200 shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <p class="text-[10px] text-emerald-800 uppercase font-bold">Total Recettes</p>
                    <p class="text-xl font-black text-emerald-900">{{ number_format($totalRecettes, 0, ',', ' ') }} <span class="text-xs font-normal">CFA</span></p>
                </div>
            </div>
        </div>
        <!-- Dépenses -->
        <div class="p-4 rounded-2xl bg-rose-100 border-2 border-rose-200 shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-gas-pump"></i>
                </div>
                <div>
                    <p class="text-[10px] text-rose-800 uppercase font-bold">Dépenses Exploitation</p>
                    <p class="text-xl font-black text-rose-900">{{ number_format($totalDepenses, 0, ',', ' ') }} <span class="text-xs font-normal">CFA</span></p>
                </div>
            </div>
        </div>
        <!-- Résultat -->
        <div class="p-4 rounded-2xl bg-indigo-100 border-2 border-indigo-200 shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div>
                    <p class="text-[10px] text-indigo-800 uppercase font-bold">Résultat Net</p>
                    <p class="text-xl font-black text-indigo-900">{{ number_format($beneficeNet, 0, ',', ' ') }} <span class="text-xs font-normal">CFA</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── STATS CARDS ─── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 animate-fade-in-up shrink-0" style="animation-delay:0.2s">
        {{-- Recettes du mois --}}
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-emerald-100 uppercase tracking-wider font-semibold">Recettes mois</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-coins text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ number_format($recettes_mois ?? 0, 0, ',', ' ') }} <span class="text-[10px] font-normal">FCFA</span></p>
            <div class="mt-2 pt-2 border-t border-white/20 flex items-center gap-1">
                @if(($recettes_evolution ?? 0) > 0)
                    <i class="fas fa-arrow-up text-[10px] text-emerald-200"></i>
                    <span class="text-[10px] text-emerald-100">+{{ $recettes_evolution }}% vs mois préc.</span>
                @elseif(($recettes_evolution ?? 0) < 0)
                    <i class="fas fa-arrow-down text-[10px] text-red-300"></i>
                    <span class="text-[10px] text-emerald-100">{{ $recettes_evolution }}% vs mois préc.</span>
                @else
                    <span class="text-[10px] text-emerald-100">{{ now()->format('M Y') }}</span>
                @endif
            </div>
        </div>

        {{-- Total recettes --}}
        <div class="rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-teal-100 uppercase tracking-wider font-semibold">Total recettes</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ number_format($recettes_total ?? 0, 0, ',', ' ') }} <span class="text-[10px] font-normal">FCFA</span></p>
            <div class="mt-2 pt-2 border-t border-white/20">
                <div class="w-full bg-white/20 rounded-full h-1">
                    <div class="bg-white rounded-full h-1 transition-all duration-700" style="width: {{ min(100, $recettes_pct ?? 0) }}%"></div>
                </div>
            </div>
        </div>

        {{-- Nombre de recettes --}}
        <div class="rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-cyan-100 uppercase tracking-wider font-semibold">Nb. Recettes</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ $nb_recettes ?? 0 }}</p>
            <div class="mt-2 pt-2 border-t border-white/20">
                <span class="text-[10px] text-cyan-100">{{ $nb_recettes_mois ?? 0 }} ce mois-ci</span>
            </div>
        </div>

        {{-- Rapports --}}
        <div class="rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 p-4 shadow-lg hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-indigo-100 uppercase tracking-wider font-semibold">Rapports</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-file-pdf text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ $nb_rapports ?? 0 }}</p>
            <div class="mt-2 pt-2 border-t border-white/20">
                <span class="text-[10px] text-indigo-100">Disponibles en PDF & Excel</span>
            </div>
        </div>
    </div>

    {{-- ─── MODULES & GRAPHIQUE ─── --}}
    <div class="flex flex-col lg:flex-row gap-3 flex-1 min-h-0 animate-fade-in-up" style="animation-delay:0.2s">
        
        {{-- MODULE RECETTES --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 flex-1 flex flex-col min-h-0">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 shrink-0 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-white/20 rounded-lg">
                            <i class="fas fa-coins text-white text-sm"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white">Dernières Recettes</h2>
                    </div>
                    <a href="{{ route('comptable.recettes.index') }}" class="text-[10px] bg-white/20 hover:bg-white/30 text-white px-2 py-1 rounded transition font-medium">Voir</a>
                </div>
            </div>
            
            <div class="p-3 flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2">
                @forelse($dernieres_recettes ?? [] as $recette)
                <div class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-gray-700 last:border-0 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <i class="fas fa-calendar text-emerald-600 dark:text-emerald-400 text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($recette->mois ?? $recette->date)->isoFormat('MMM YYYY') }}
                            </p>
                            <p class="text-[10px] text-gray-400">{{ $recette->type ?? 'Recette' }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                        {{ number_format($recette->montant, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center flex-1 text-gray-400 text-center">
                    <i class="fas fa-inbox text-2xl mb-1 text-gray-200 dark:text-gray-600"></i>
                    <p class="text-[10px]">Aucune recette</p>
                </div>
                @endforelse
            </div>
            <div class="p-3 shrink-0 border-t border-gray-100 dark:border-gray-700 grid grid-cols-2 gap-2">
                <a href="{{ route('comptable.recettes.create') }}" class="flex items-center justify-center gap-1 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition hover:scale-[1.02]">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
                <a href="{{ route('comptable.rapports.index') }}" class="flex items-center justify-center gap-1 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold rounded-lg transition hover:scale-[1.02]">
                    <i class="fas fa-chart-bar"></i> Rapports
                </a>
            </div>
        </div>

        {{-- GRAPHIQUE EVOLUTION --}}
        @if(isset($chart_labels) && count($chart_labels) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 flex-[2] flex flex-col min-h-0">
            <div class="p-4 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                        <i class="fas fa-chart-area text-emerald-600 dark:text-emerald-400 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-gray-800 dark:text-white">Évolution des Recettes</h2>
                        <p class="text-[10px] text-gray-400">12 derniers mois</p>
                    </div>
                </div>
            </div>
            <div class="flex-1 min-h-0 w-full p-2 flex items-center justify-center relative">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 flex-[2] flex flex-col min-h-0 items-center justify-center">
            <i class="fas fa-chart-bar text-4xl text-gray-200 dark:text-gray-700 mb-2"></i>
            <p class="text-sm text-gray-400">Aucune donnée pour le graphique</p>
        </div>
        @endif
    </div>

</div>

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
                borderRadius: 4,
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
                pointRadius: 3,
                tension: 0.4,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: 10 },
            plugins: {
                legend: { labels: { color: '#6b7280', font: { size: 10 } } },
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
