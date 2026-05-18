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
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-file-invoice text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Gestion Documentaire</h1>
                    <p class="text-red-100 text-sm mt-1">Suivi des pièces administratives et expirations</p>
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

    <div class="list-scroll-container custom-scrollbar grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 animate-fade-in-up" style="animation-delay: 0.2s">
        @forelse($documents as $doc)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md hover:scale-[1.02] transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center text-xl">
                    <i class="fas fa-file-alt"></i>
                </div>
                @php
                    $isExpiring = $doc->date_expiration && $doc->date_expiration->isPast();
                    $isNear = $doc->date_expiration && $doc->date_expiration->diffInDays(now()) < 30;
                @endphp
                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg 
                    {{ $isExpiring ? 'bg-red-100 text-red-700' : ($isNear ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">
                    {{ $isExpiring ? 'Expiré' : ($isNear ? 'Expire bientôt' : 'Valide') }}
                </span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white truncate" title="{{ $doc->type }}">{{ $doc->type }}</h3>
            <p class="text-xs text-gray-500 mb-4">Véhicule: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $doc->vehicule->immatriculation ?? 'N/A' }}</span></p>
            
            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl mb-5">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-[10px] text-gray-400 uppercase font-bold">Expiration</span>
                    <span class="text-xs font-bold {{ $isExpiring ? 'text-red-600' : 'text-gray-700 dark:text-gray-300' }}">
                        {{ $doc->date_expiration ? $doc->date_expiration->format('d/m/Y') : 'N/A' }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-600 h-1.5 rounded-full overflow-hidden">
                    <div class="h-full {{ $isExpiring ? 'bg-red-500' : ($isNear ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: 100%"></div>
                </div>
            </div>

            <a href="{{ route('manager.documents.show', $doc) }}" class="block text-center py-2.5 bg-gray-50 dark:bg-gray-700/50 hover:bg-red-600 hover:text-white text-sm font-bold text-gray-700 dark:text-gray-300 rounded-xl transition-all duration-300">
                Détails du document
            </a>
        </div>
        @empty
        <div class="col-span-full py-20 text-center text-gray-400">
            <i class="fas fa-folder-open text-4xl mb-4 opacity-20"></i>
            <p>Aucun document trouvé.</p>
        </div>
        @endforelse
    </div>
    
    @if($documents->hasPages())
    <div class="shrink-0 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
        {{ $documents->links() }}
    </div>
    @endif
</div>
@endsection
