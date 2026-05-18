@extends('layouts.gestionnaire')

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
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-tools text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Suivi Maintenance</h1>
                    <p class="text-amber-100 text-sm mt-1">Consultation des interventions techniques</p>
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

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col list-scroll-container animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="overflow-x-auto flex-1 custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider sticky top-0 z-10 backdrop-blur-md">
                        <th class="p-4 font-bold">Véhicule</th>
                        <th class="p-4 font-bold">Type</th>
                        <th class="p-4 font-bold">Date Prévue</th>
                        <th class="p-4 font-bold">Statut</th>
                        <th class="p-4 font-bold">Coût</th>
                        <th class="p-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($maintenances as $m)
                    <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors">
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $m->vehicule->immatriculation ?? 'N/A' }}</td>
                        <td class="p-4 text-gray-600 dark:text-gray-300">{{ ucfirst($m->type) }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $m->date_prevue->format('d/m/Y') }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-lg
                                {{ $m->statut == 'terminee' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ $m->statut }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-amber-600 dark:text-amber-400">{{ $m->cout ? number_format($m->cout, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('gestionnaire.maintenances.show', $m) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 hover:bg-amber-100 text-gray-400 hover:text-amber-600 transition-all duration-300">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-12 text-center text-gray-400">Aucune maintenance trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenances->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 shrink-0">
            {{ $maintenances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
