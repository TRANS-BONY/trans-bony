@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-violet-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-file-alt text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white truncate max-w-xs md:max-w-lg">{{ $rapport->titre }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                            {{ $rapport->statut === 'publié' ? 'bg-emerald-400/30 text-emerald-100' : 'bg-amber-400/30 text-amber-100' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $rapport->statut === 'publié' ? 'bg-emerald-300' : 'bg-amber-300' }} animate-pulse"></span>
                            {{ ucfirst($rapport->statut) }}
                        </span>
                        <span class="text-indigo-200 text-xs">{{ ucfirst($rapport->type) }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.rapports.edit', $rapport) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-indigo-700 font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.rapports.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl border border-white/30 backdrop-blur-sm transition hover:scale-105">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- SIDEBAR INFOS --}}
        <div class="space-y-4 animate-fade-in-up" style="animation-delay:0.1s">

            {{-- Période --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 border border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-indigo-400"></i> Période
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Début</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $rapport->periode_debut->isoFormat('D MMMM YYYY') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Fin</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $rapport->periode_fin->isoFormat('D MMMM YYYY') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-xs text-gray-400">Durée</span>
                        <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $rapport->duree }} jour{{ $rapport->duree > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Méta --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 border border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-gray-400"></i> Méta
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Type</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white capitalize">{{ $rapport->type }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Créé par</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ optional($rapport->user)->name ?? auth()->user()->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Créé le</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $rapport->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Modifié le</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $rapport->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 border border-gray-100 dark:border-gray-700 space-y-2">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Actions</h3>
                <a href="{{ route('admin.rapports.edit', $rapport) }}"
                   class="flex items-center justify-center gap-2 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold rounded-xl transition hover:scale-105">
                    <i class="fas fa-edit"></i> Modifier le rapport
                </a>
                <a href="{{ route('admin.rapports.pdf') }}"
                   class="flex items-center justify-center gap-2 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition hover:scale-105">
                    <i class="fas fa-file-pdf"></i> Exporter PDF
                </a>
                <a href="{{ route('admin.rapports.excel') }}"
                   class="flex items-center justify-center gap-2 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition hover:scale-105">
                    <i class="fas fa-file-excel"></i> Exporter Excel
                </a>
                <form method="POST" action="{{ route('admin.rapports.destroy', $rapport) }}">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer ce rapport définitivement ?')"
                            class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-semibold rounded-xl transition hover:scale-105">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>

        {{-- CONTENU PRINCIPAL --}}
        <div class="lg:col-span-2 space-y-5 animate-fade-in-up" style="animation-delay:0.15s">

            {{-- Stats du rapport --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-4 text-center shadow-md">
                    <i class="fas fa-coins text-white/70 text-xl mb-2"></i>
                    <p class="text-xl font-black text-white">{{ number_format($rapport->recettes_total, 0, ',', ' ') }}</p>
                    <p class="text-xs text-emerald-100 mt-0.5">Franc CFA recettes</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 text-center shadow-md">
                    <i class="fas fa-route text-white/70 text-xl mb-2"></i>
                    <p class="text-xl font-black text-white">{{ $rapport->nb_voyages }}</p>
                    <p class="text-xs text-blue-100 mt-0.5">Voyages</p>
                </div>
                <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl p-4 text-center shadow-md">
                    <i class="fas fa-truck text-white/70 text-xl mb-2"></i>
                    <p class="text-xl font-black text-white">{{ $rapport->nb_vehicules }}</p>
                    <p class="text-xs text-violet-100 mt-0.5">Véhicules</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-4 text-center shadow-md">
                    <i class="fas fa-user-tie text-white/70 text-xl mb-2"></i>
                    <p class="text-xl font-black text-white">{{ $rapport->nb_chauffeurs }}</p>
                    <p class="text-xs text-amber-100 mt-0.5">Chauffeurs</p>
                </div>
            </div>

            {{-- Barre progression recettes --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-chart-bar text-indigo-500"></i> Recettes de la période
                    </h3>
                    <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                        {{ number_format($rapport->recettes_total, 0, ',', ' ') }} Franc CFA
                    </span>
                </div>
                @php
                    $recettesTotal = \App\Models\RecetteMensuelle::sum('montant') ?: 1;
                    $pct = min(100, round($rapport->recettes_total / $recettesTotal * 100));
                @endphp
                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-emerald-400 to-teal-500 h-3 rounded-full transition-all duration-700"
                         style="width: {{ $pct }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $pct }}% du total cumulé des recettes</p>
            </div>

            {{-- Notes --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-base font-bold text-gray-800 dark:text-white flex items-center gap-2 mb-4">
                    <i class="fas fa-sticky-note text-amber-500"></i> Notes & Observations
                </h3>
                @if($rapport->notes)
                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800">
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $rapport->notes }}</p>
                    </div>
                @else
                    <p class="text-sm text-gray-400 italic">Aucune note renseignée.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px);  } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection

