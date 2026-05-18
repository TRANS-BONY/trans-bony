@extends('layouts.app')

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
        gap: 1rem;
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
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>

<div class="module-index-wrapper custom-scrollbar">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-700 via-gray-700 to-zinc-800 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-history text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        @isset($user) Journal d'Audit : {{ $user->name }} @else Journal d'Audit @endisset
                    </h1>
                    <p class="text-gray-300 text-sm mt-1">
                        @isset($user) Historique complet des actions de cet utilisateur @else Traçabilité complète des actions effectuées sur le système @endisset
                    </p>
                </div>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.audits.clear') }}" method="POST" onsubmit="return confirm('⚠️ ATTENTION : Voulez-vous vraiment vider tout le journal d\'audit ? Cette action est irréversible.')">
                    @csrf @method('POST')
                    <button type="submit" class="px-5 py-2.5 bg-red-500/20 hover:bg-red-500 border border-red-500/50 text-white rounded-xl transition-all flex items-center gap-2 backdrop-blur-sm">
                        <i class="fas fa-trash-alt"></i> Vider le journal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Total Actions</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $audits->total() }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Aujourd'hui</p>
            <p class="text-2xl font-bold text-emerald-600">{{ \App\Models\Audit::whereDate('created_at', now())->count() }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Tables Impactées</p>
            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Audit::distinct('table_name')->count() }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider">Dernière Action</p>
            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $audits->first()?->created_at->diffForHumans() ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="relative animate-fade-in-up" style="animation-delay: 0.2s">
        <form method="GET" class="relative group">
            <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 z-10 cursor-pointer hover:opacity-80 transition-opacity"><i class="fas fa-search"></i></button>
            <input type="text" name="search" placeholder="Rechercher une action, une table ou un ID..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-slate-500 outline-none shadow-sm transition-all">
        </form>
    </div>

    <!-- Tableau -->
    <div class="list-scroll-container custom-scrollbar rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-xl animate-fade-in-up" style="animation-delay: 0.3s">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date & Heure</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Cible</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Détails</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($audits as $audit)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $audit->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $audit->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($audit->user)
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                        {{ substr($audit->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium">{{ $audit->user->name }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Système</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeColor = match($audit->action) {
                                    'CREATE' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'UPDATE' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'DELETE' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                    'LOGIN'  => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                    default  => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400'
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $badgeColor }}">
                                {{ $audit->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-tight">{{ $audit->table_name }}</div>
                            <div class="text-[10px] text-gray-400">ID: {{ $audit->record_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-1 max-w-xs">{{ $audit->ip_address }} • {{ Str::limit($audit->user_agent, 40) }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.audits.show', $audit->id) }}" class="p-2 bg-slate-50 dark:bg-gray-700 text-slate-600 dark:text-gray-300 rounded-lg hover:bg-slate-600 hover:text-white transition-all">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <form action="{{ route('admin.audits.destroy', $audit->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette entrée ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center text-gray-400">Aucun enregistrement d'audit trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($audits->hasPages())
    <div class="shrink-0 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-200 dark:border-gray-700">
        {{ $audits->links() }}
    </div>
    @endif
</div>
@endsection
