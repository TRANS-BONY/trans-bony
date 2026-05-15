@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col space-y-4">
    <!-- En-tête Dynamique -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-500/10 flex items-center justify-center rounded-2xl border border-indigo-500/20 shadow-inner">
                <i class="fas fa-chart-pie text-indigo-500 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-black text-gray-900 dark:text-white tracking-tight">Rapports & Statistiques</h1>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mt-0.5">Analyse de performance • {{ $nb_rapports }} rapports</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <form method="GET" class="relative flex-1 md:flex-initial">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" placeholder="Rechercher un rapport..." value="{{ request('search') }}"
                       class="w-full md:w-64 pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-inner">
            </form>
            <a href="{{ route('admin.rapports.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-indigo-600/20 transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-plus text-xs"></i>
                <span>Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Grille de Stats Premium -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 shrink-0">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-16 h-16 bg-blue-500/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-bus text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Véhicules</p>
                    <p class="text-xl font-black text-gray-900 dark:text-white">{{ $vehicules }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-16 h-16 bg-orange-500/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="fas fa-route text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Voyages</p>
                    <p class="text-xl font-black text-gray-900 dark:text-white">{{ $voyages }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-16 h-16 bg-amber-500/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600">
                    <i class="fas fa-user-tie text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Chauffeurs</p>
                    <p class="text-xl font-black text-gray-900 dark:text-white">{{ $chauffeurs }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-600 to-violet-700 p-5 rounded-3xl border-none shadow-lg shadow-indigo-600/20 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-coins text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-indigo-100 font-bold">Total Recettes</p>
                    <p class="text-xl font-black text-white leading-tight">{{ number_format($recettes_total ?? 0, 0, ',', ' ') }} <span class="text-[10px] font-medium opacity-70">CFA</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des Rapports (Scrollable) -->
    <div class="flex-1 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col min-h-0 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700/50 flex justify-between items-center bg-gray-50/30 dark:bg-gray-900/20 shrink-0">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                Historique des rapports
            </h3>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.rapports.pdf') }}" class="w-8 h-8 flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Export PDF">
                    <i class="fas fa-file-pdf text-sm"></i>
                </a>
                <a href="{{ route('admin.rapports.excel') }}" class="w-8 h-8 flex items-center justify-center text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors" title="Export Excel">
                    <i class="fas fa-file-excel text-sm"></i>
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar">
            <table class="w-full text-left">
                <thead class="sticky top-0 bg-white dark:bg-gray-800 z-10">
                    <tr class="text-[10px] uppercase tracking-widest text-gray-400 font-bold border-b border-gray-50 dark:border-gray-700">
                        <th class="px-6 py-4">Rapport / Période</th>
                        <th class="px-6 py-4">Type & Statut</th>
                        <th class="px-6 py-4 text-right">Recettes</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                    @forelse($rapports as $rapport)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white leading-none">{{ Str::limit($rapport->titre, 40) }}</p>
                                    <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1.5 uppercase font-semibold">
                                        <i class="far fa-calendar-alt text-indigo-400"></i>
                                        {{ $rapport->periode_debut->format('d/m/Y') }} → {{ $rapport->periode_fin->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-2">
                                <span class="w-fit px-2 py-0.5 rounded bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 text-[9px] font-black uppercase tracking-tighter">
                                    {{ $rapport->type }}
                                </span>
                                <span class="flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-widest {{ $rapport->statut === 'publié' ? 'text-emerald-500' : 'text-amber-500' }}">
                                    <span class="w-1 h-1 rounded-full bg-current animate-pulse"></span>
                                    {{ $rapport->statut }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <p class="text-sm font-black text-gray-900 dark:text-white leading-none">
                                {{ number_format($rapport->recettes_total, 0, ',', ' ') }}
                            </p>
                            <p class="text-[9px] text-gray-400 uppercase font-bold mt-1 tracking-tighter">FCFA</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.rapports.show', $rapport) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all" title="Voir">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.rapports.edit', $rapport) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all" title="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.rapports.destroy', $rapport) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all" title="Supprimer">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900/50 rounded-2xl flex items-center justify-center text-gray-200 dark:text-gray-700 shadow-inner">
                                    <i class="fas fa-folder-open text-2xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Aucun rapport trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rapports->hasPages())
        <div class="px-6 py-3 border-t border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30 shrink-0">
            {{ $rapports->links() }}
        </div>
        @endif
    </div>

    <!-- Chart Section (Compact) -->
    @if(count($chart_labels) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 shrink-0">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-chart-line text-indigo-500 text-xs"></i>
                <h4 class="text-[10px] uppercase font-black tracking-[0.1em] text-gray-400">Évolution des recettes (12 derniers mois)</h4>
            </div>
        </div>
        <div class="h-32">
            <canvas id="rapportChart"></canvas>
        </div>
    </div>
    @endif
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); }
</style>

@if(count($chart_labels) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('rapportChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chart_labels),
            datasets: [{
                label: 'Recettes',
                data: @json($chart_data),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#6366f1',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 12,
                    backgroundColor: 'rgba(31, 41, 55, 0.95)',
                    titleFont: { size: 10, weight: 'bold' },
                    bodyFont: { size: 12, weight: 'bold' },
                    cornerRadius: 12,
                    callbacks: { label: (ctx) => `${ctx.raw.toLocaleString()} CFA` }
                }
            },
            scales: {
                y: { display: false },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 9, weight: 'bold' }, color: '#9ca3af' }
                }
            }
        }
    });
});
</script>
@endif
@endsection
