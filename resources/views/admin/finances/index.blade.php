@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08 .402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Recettes Mensuelles</h1>
                    <p class="text-emerald-100 text-sm mt-1">Suivez les revenus générés par votre flotte</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs text-white">Année {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider">Total recettes</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($recettes->sum('montant'), 2) }} FCFA</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-2 border-t border-white/20">
                <p class="text-xs text-emerald-100">Cumul annuel</p>
            </div>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-cyan-100 uppercase tracking-wider">Moyenne mensuelle</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($recettes->avg('montant') ?? 0, 2) }} FCFA</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-2 border-t border-white/20">
                <p class="text-xs text-cyan-100">Par mois</p>
            </div>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-100 uppercase tracking-wider">Véhicules</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules ?? 0 }}</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        <circle cx="6" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="18" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-2 border-t border-white/20">
                <p class="text-xs text-blue-100">Flotte totale</p>
            </div>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-5 hover:scale-105 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider">Voyages</p>
                    <p class="text-3xl font-bold text-white">{{ $voyages ?? 0 }}</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-2 border-t border-white/20">
                <p class="text-xs text-amber-100">{{ now()->format('F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Historique des recettes</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Liste détaillée des revenus mensuels</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.recettes.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter une recette
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-left">Mois</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-left">Montant</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recettes as $recette)
                        <tr class="hover:bg-gray-50 transition-all duration-300">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-emerald-100 rounded-lg">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($recette->mois)->format('F Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($recette->mois)->format('M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08 .402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-xl font-bold text-emerald-600">{{ number_format($recette->montant, 2) }} FCFA</span>
                                </div>
                                @php
                                    $montantPrecedent = $recettes->where('mois', '<', $recette->mois)->last();
                                    $evolution = $montantPrecedent ? (($recette->montant - $montantPrecedent->montant) / $montantPrecedent->montant) * 100 : null;
                                @endphp
                                @if($evolution !== null)
                                    <div class="flex items-center gap-1 mt-1">
                                        @if($evolution > 0)
                                            <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-xs text-emerald-600">+{{ number_format($evolution, 1) }}%</span>
                                        @elseif($evolution < 0)
                                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                            </svg>
                                            <span class="text-xs text-red-600">{{ number_format($evolution, 1) }}%</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.recettes.show', $recette) }}" class="group p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 hover:scale-110" title="Voir">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.recettes.edit', $recette) }}" class="group p-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition-all duration-300 hover:scale-110" title="Modifier">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.recettes.destroy', $recette) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Supprimer?')" class="p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-all duration-300 hover:scale-110" title="Supprimer">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="p-4 rounded-full bg-gray-100">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08 .402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-700">Aucune recette</p>
                                        <p class="text-sm text-gray-500 mt-1">Commencez par ajouter la première</p>
                                    </div>
                                    <a href="{{ route('admin.recettes.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all duration-300 hover:scale-105 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Ajouter une recette
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recettes->hasPages())
            <div class="border-t border-gray-200 p-4 bg-gradient-to-r from-gray-50 to-white">
                {{ $recettes->links() }}
            </div>
            @endif
        </div>
    </div>

    @if($recettes->count() > 0)
    <div class="animate-fade-in-up" style="animation-delay: 0.3s">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">Évolution des recettes</h2>
            </div>
            <div class="p-6">
                <canvas id="recettesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
nav[aria-label="Pagination"] { display: flex; justify-content: center; }
nav[aria-label="Pagination"] .relative { background: rgba(255, 255, 255, 0.9); border: 1px solid #e5e7eb; color: #374151; transition: all 0.3s ease; }
nav[aria-label="Pagination"] .relative:hover { background: #10b981; border-color: #10b981; color: white; transform: scale(1.05); }
nav[aria-label="Pagination"] .relative[aria-current="page"] span { background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; }
* { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
</style>

@if($recettes->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('recettesChart').getContext('2d');
    const mois = @json($recettes->pluck('mois')->map(function($mois) { return Carbon\Carbon::parse($mois)->format('M Y'); }));
    const montants = @json($recettes->pluck('montant'));
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: mois,
            datasets: [{
                label: 'Recettes (FCFA)',
                data: montants,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { labels: { color: '#374151', font: { size: 12, weight: '500' } } },
                tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', titleColor: '#fff', bodyColor: '#e5e7eb', borderColor: '#10b981', borderWidth: 1, callbacks: { label: function(context) { return `Recettes: ${context.raw.toLocaleString('fr-FR')} FCFA`; } } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { color: '#6b7280', callback: function(value) { return value.toLocaleString('fr-FR') + ' FCFA'; } }, title: { display: true, text: 'Montant (FCFA)', color: '#6b7280', font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { color: '#6b7280' }, title: { display: true, text: 'Mois', color: '#6b7280', font: { size: 11 } } }
            },
            animation: { duration: 1500, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endif

@endsection
