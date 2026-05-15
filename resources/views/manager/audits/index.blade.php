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
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-700 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-clipboard-check text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Audits & Logs</h1>
                    <p class="text-cyan-100 text-sm mt-1">Traçabilité des actions effectuées sur le système</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/50 group-focus-within:text-white transition-colors"></i>
                    <input type="text" name="search" placeholder="Rechercher une action..." value="{{ request('search') }}"
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
                        <th class="p-4 font-bold">Horodatage</th>
                        <th class="p-4 font-bold">Utilisateur</th>
                        <th class="p-4 font-bold">Action</th>
                        <th class="p-4 font-bold">Description</th>
                        <th class="p-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($audits as $audit)
                    <tr class="hover:bg-cyan-50/30 dark:hover:bg-cyan-900/10 transition-colors">
                        <td class="p-4">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $audit->created_at->format('d/m/Y') }}</p>
                            <p class="text-[10px] text-gray-400 font-mono">{{ $audit->created_at->format('H:i:s') }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($audit->user->name ?? '?', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $audit->user->name ?? 'Système' }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                {{ $audit->action }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $audit->description }}">
                            {{ $audit->description }}
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('manager.audits.show', $audit->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 hover:bg-cyan-100 text-gray-400 hover:text-cyan-600 transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-12 text-center text-gray-400">Aucun log d'audit trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($audits->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 shrink-0">
            {{ $audits->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
