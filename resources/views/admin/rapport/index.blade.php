@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-violet-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Rapports & Statistiques</h1>
                    <p class="text-indigo-100 text-sm mt-1">{{ now()->isoFormat('MMMM YYYY') }} — {{ $nb_rapports }} rapport(s) enregistré(s)</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.rapports.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-indigo-700 font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                    <i class="fas fa-plus"></i> Nouveau rapport
                </a>
                <a href="{{ route('admin.rapports.pdf') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('admin.rapports.excel') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 animate-fade-in-up" style="animation-delay:0.1s">
        <div class="group rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-100 uppercase tracking-wider font-semibold">Véhicules</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $vehicules }}</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-truck text-white text-xl"></i>
                </div>
            </div>
        </div>
        <div class="group rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider font-semibold">Voyages</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $voyages }}</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-route text-white text-xl"></i>
                </div>
            </div>
        </div>
        <div class="group rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 p-6 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-violet-100 uppercase tracking-wider font-semibold">Chauffeurs</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $chauffeurs }}</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-user-tie text-white text-xl"></i>
                </div>
            </div>
        </div>
        <div class="group rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 p-6 hover:scale-105 hover:shadow-xl transition-all duration-300 shadow-md cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider font-semibold">Recettes Total</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($recettes_total ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-amber-200">Franc CFA</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20 group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-coins text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- LISTE DES RAPPORTS --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 animate-fade-in-up" style="animation-delay:0.2s">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                    <i class="fas fa-list text-indigo-600 dark:text-indigo-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">Rapports enregistrés</h2>
                    <p class="text-xs text-gray-400">Gérez vos rapports comptables</p>
                </div>
            </div>
            <a href="{{ route('admin.rapports.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-sm font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all">
                <i class="fas fa-plus"></i> Créer
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Titre</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Type</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">Période</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Recettes</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">Statut</th>
                        <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($rapports as $rapport)
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-alt text-indigo-600 dark:text-indigo-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">{{ Str::limit($rapport->titre, 40) }}</p>
                                    <p class="text-xs text-gray-400">Créé le {{ $rapport->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                {{ $rapport->type === 'mensuel'      ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                {{ $rapport->type === 'trimestriel'  ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : '' }}
                                {{ $rapport->type === 'annuel'       ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300' : '' }}
                                {{ $rapport->type === 'personnalisé' ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                {{ ucfirst($rapport->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $rapport->periode_debut->format('d/m/Y') }}
                                <span class="text-gray-300 mx-1">→</span>
                                {{ $rapport->periode_fin->format('d/m/Y') }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $rapport->duree }} jours</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-base font-bold text-emerald-600 dark:text-emerald-400">
                                {{ number_format($rapport->recettes_total, 0, ',', ' ') }} Franc CFA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                {{ $rapport->statut === 'publié'    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : '' }}
                                {{ $rapport->statut === 'brouillon' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $rapport->statut === 'publié' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                {{ ucfirst($rapport->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.rapports.show', $rapport) }}"
                                   class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-800/40 text-indigo-600 dark:text-indigo-400 transition hover:scale-110" title="Voir">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.rapports.edit', $rapport) }}"
                                   class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-800/40 text-blue-600 dark:text-blue-400 transition hover:scale-110" title="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.rapports.destroy', $rapport) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer « {{ $rapport->titre }} » ?')"
                                            class="p-2 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-800/40 text-red-600 dark:text-red-400 transition hover:scale-110" title="Supprimer">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-3xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <p class="text-base font-semibold text-gray-500 dark:text-gray-400">Aucun rapport créé</p>
                                <p class="text-sm">Créez votre premier rapport comptable</p>
                                <a href="{{ route('admin.rapports.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-md hover:scale-105 transition-all">
                                    <i class="fas fa-plus"></i> Créer un rapport
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rapports->hasPages())
        <div class="border-t border-gray-100 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-750">
            {{ $rapports->links() }}
        </div>
        @endif
    </div>

    {{-- EXPORTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up" style="animation-delay:0.3s">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="h-1.5 bg-gradient-to-r from-red-500 to-pink-500"></div>
            <div class="p-5 flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl shadow-md flex-shrink-0">
                    <i class="fas fa-file-pdf text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 dark:text-white">Export PDF</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Rapport complet avec statistiques</p>
                </div>
                <a href="{{ route('admin.rapports.pdf') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl shadow transition hover:scale-105">
                    <i class="fas fa-download"></i> Télécharger
                </a>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="h-1.5 bg-gradient-to-r from-green-500 to-emerald-600"></div>
            <div class="p-5 flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-md flex-shrink-0">
                    <i class="fas fa-file-excel text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 dark:text-white">Export Excel</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Données tabulaires analysables</p>
                </div>
                <a href="{{ route('admin.rapports.excel') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow transition hover:scale-105">
                    <i class="fas fa-download"></i> Télécharger
                </a>
            </div>
        </div>
    </div>

    {{-- GRAPHIQUE --}}
    @if(count($chart_labels) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 animate-fade-in-up" style="animation-delay:0.4s">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                <i class="fas fa-chart-area text-indigo-600 dark:text-indigo-400"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Évolution des Recettes</h2>
                <p class="text-xs text-gray-400">12 derniers mois</p>
            </div>
        </div>
        <canvas id="rapportChart" height="90"></canvas>
    </div>
    @endif

</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px);  } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>

@if(count($chart_labels) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('rapportChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($chart_labels),
            datasets: [{
                label: 'Recettes (Franc CFA)',
                data: @json($chart_data),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.08)',
                borderWidth: 3,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { labels: { color: '#6b7280', font: { size: 12, weight: '500' } } },
                tooltip: {
                    backgroundColor: 'rgba(17,24,39,0.9)',
                    titleColor: '#c7d2fe',
                    bodyColor: '#e0e7ff',
                    borderColor: '#6366f1',
                    borderWidth: 1,
                    callbacks: { label: ctx => ` ${ctx.raw.toLocaleString('fr-FR')} Franc CFA` }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#9ca3af', callback: v => v.toLocaleString('fr-FR') } },
                x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
            },
            animation: { duration: 1500, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endif
@endsection

