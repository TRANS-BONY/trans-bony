@extends('layouts.manager')

@section('content')
<style>
    /* Désactiver le scroll global */
    html, body { overflow: hidden !important; height: 100vh !important; }
    
    /* Scrollbar minimaliste */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
    
    /* Wrapper Layout */
    .module-index-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        height: calc(100vh - 100px);
        overflow: hidden;
        padding-bottom: 0.5rem;
    }
    
    .module-index-wrapper > * {
        flex-shrink: 0;
    }
    
    .module-index-wrapper > .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>

<div class="module-index-wrapper custom-scrollbar">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-chart-pie text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Rapports d'Activité</h1>
                    <p class="text-indigo-100 text-sm mt-1">Analyse des performances et bilans périodiques</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" class="relative group">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/50 group-focus-within:text-white transition-colors z-10 cursor-pointer hover:opacity-80 transition-opacity"><i class="fas fa-search"></i></button>
                    <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                           class="w-64 pl-12 pr-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:bg-white/20 focus:ring-2 focus:ring-white/30 outline-none backdrop-blur-sm transition-all">
                </form>
            </div>
        </div>
    </div>

    <div class="list-scroll-container custom-scrollbar grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.2s">
        @forelse($rapports as $r)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    {{ $r->type }}
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $r->titre }}</h3>
            <p class="text-xs text-gray-400 mb-4 italic">Par {{ $r->user->name }} • {{ $r->created_at->format('d/m/Y') }}</p>
            
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-6 border-y border-gray-50 dark:border-gray-700 py-3">
                <div class="flex flex-col gap-1 flex-1">
                    <span class="text-gray-400 uppercase text-[9px] font-bold">Période</span>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $r->periode_debut->format('d/m') }} - {{ $r->periode_fin->format('d/m/Y') }}</span>
                </div>
                <div class="flex flex-col gap-1 text-right">
                    <span class="text-gray-400 uppercase text-[9px] font-bold">Recettes</span>
                    <span class="font-bold text-emerald-600">{{ number_format($r->total_recettes, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>

            <a href="{{ route('manager.rapports.show', $r) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-indigo-600 hover:text-white text-sm font-bold text-gray-700 dark:text-gray-300 rounded-xl transition-all duration-300">
                <i class="fas fa-eye text-xs"></i> Consulter le rapport
            </a>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-chart-pie text-3xl text-gray-300"></i>
            </div>
            <p class="text-gray-500">Aucun rapport disponible.</p>
        </div>
        @endforelse
    </div>
    
    @if($rapports->hasPages())
    <div class="shrink-0 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
        {{ $rapports->links() }}
    </div>
    @endif
</div>
@endsection
