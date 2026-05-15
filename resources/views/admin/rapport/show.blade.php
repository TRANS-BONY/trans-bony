@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col space-y-4">
    <!-- En-tête Dynamique Premium -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-violet-700 p-6 md:p-8 shadow-xl shrink-0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl -ml-10 -mb-10"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30 shadow-inner">
                    <i class="fas fa-file-contract text-white text-2xl"></i>
                </div>
                <div>
                    <nav class="flex items-center gap-2 text-indigo-100/70 text-[9px] uppercase font-black tracking-widest mb-1.5">
                        <a href="{{ route('admin.rapports.index') }}" class="hover:text-white transition-colors">Rapports</a>
                        <i class="fas fa-chevron-right text-[7px]"></i>
                        <span>Détails</span>
                    </nav>
                    <h1 class="text-xl md:text-2xl font-black text-white leading-tight tracking-tight">{{ $rapport->titre }}</h1>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="px-2.5 py-0.5 bg-white/20 backdrop-blur-sm rounded-md text-[9px] font-black text-white uppercase tracking-widest border border-white/10">
                            {{ $rapport->type }}
                        </span>
                        <span class="flex items-center gap-1.5 text-[11px] font-bold text-indigo-100">
                            <i class="far fa-calendar-alt opacity-60"></i>
                            {{ $rapport->periode_debut->format('d/m/Y') }} — {{ $rapport->periode_fin->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.rapports.edit', $rapport) }}" class="px-5 py-2.5 bg-white text-indigo-600 font-bold rounded-2xl shadow-lg hover:scale-105 active:scale-95 transition-all text-xs uppercase tracking-widest">
                    <i class="fas fa-edit mr-2"></i> Modifier
                </a>
                <a href="{{ route('admin.rapports.index') }}" class="w-10 h-10 flex items-center justify-center bg-white/10 hover:bg-white/20 text-white rounded-2xl border border-white/20 backdrop-blur-sm transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Zone de Contenu Scrollable -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar pr-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-6">
            {{-- Left: Details & Stats --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Performance Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden relative group">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Recettes Période</p>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($rapport->recettes_total, 0, ',', ' ') }}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase mb-1.5">CFA</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-[10px] text-emerald-500 font-black bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1 rounded-lg w-fit uppercase tracking-wider">
                            <i class="fas fa-check-circle"></i>
                            <span>Performance Validée</span>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden relative group">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Activité Voyages</p>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $rapport->nb_voyages }}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase mb-1.5">Trajets</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-[10px] text-blue-500 font-black bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-lg w-fit uppercase tracking-wider">
                            <i class="fas fa-route"></i>
                            <span>Flux Opérationnel</span>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden relative group">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Ressources</p>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-black text-purple-600 dark:text-purple-400">{{ $rapport->nb_chauffeurs }}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase mb-1.5">Agents</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-[10px] text-purple-500 font-black bg-purple-50 dark:bg-purple-900/20 px-3 py-1 rounded-lg w-fit uppercase tracking-wider">
                            <i class="fas fa-user-tie"></i>
                            <span>Équipe active</span>
                        </div>
                    </div>
                </div>

                {{-- Notes & Content --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/20">
                        <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Observations & Analyse</h3>
                        <i class="fas fa-quote-right text-indigo-200 dark:text-gray-700"></i>
                    </div>
                    <div class="p-8">
                        @if($rapport->notes)
                            <div class="prose dark:prose-invert max-w-none">
                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{ $rapport->notes }}</p>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-gray-400 italic gap-4">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center shadow-inner">
                                    <i class="fas fa-comment-slash text-2xl opacity-20"></i>
                                </div>
                                <p class="text-xs font-bold uppercase tracking-widest">Aucune observation enregistrée</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Sidebar Details --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Technical Summary --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Fiche Technique</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium">Statut actuel</span>
                            <span class="px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest {{ $rapport->statut === 'publié' ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white' }}">
                                {{ $rapport->statut }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium">Date de début</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white tracking-tight">{{ $rapport->periode_debut->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium">Date de fin</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white tracking-tight">{{ $rapport->periode_fin->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-50 dark:border-gray-700">
                            <span class="text-xs text-gray-400 font-medium">Durée totale</span>
                            <span class="text-sm font-black text-indigo-600 dark:text-indigo-400">{{ $rapport->duree }} jours</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium">Généré par</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white tracking-tight">{{ optional($rapport->user)->name ?? 'Système' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions Sidebar --}}
                <div class="bg-gray-900 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <h3 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-6 relative">Options d'export</h3>
                    
                    <div class="space-y-3 relative">
                        <a href="{{ route('admin.rapports.pdf') }}" class="flex items-center gap-4 p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all group/btn">
                            <div class="w-10 h-10 bg-red-500/20 text-red-400 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-white">Document PDF</p>
                                <p class="text-[9px] text-gray-500 uppercase font-black tracking-tighter mt-0.5">Prêt pour impression</p>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                        </a>

                        <a href="{{ route('admin.rapports.excel') }}" class="flex items-center gap-4 p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all group/btn">
                            <div class="w-10 h-10 bg-green-500/20 text-green-400 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-white">Tableur Excel</p>
                                <p class="text-[9px] text-gray-500 uppercase font-black tracking-tighter mt-0.5">Analyse de données</p>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                        </a>

                        <button onclick="window.print()" class="w-full mt-4 flex items-center justify-center gap-3 py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                            <i class="fas fa-print"></i>
                            Imprimer Rapport
                        </button>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="p-6 bg-red-500/5 rounded-3xl border border-red-500/10">
                    <p class="text-[9px] font-black text-red-500 uppercase tracking-[0.2em] mb-4">Zone Critique</p>
                    <form method="POST" action="{{ route('admin.rapports.destroy', $rapport) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Cette action est irréversible. Continuer ?')" class="w-full flex items-center justify-center gap-2 py-3 text-red-500 hover:text-white hover:bg-red-500 border border-red-500/20 rounded-2xl transition-all text-[9px] font-black uppercase tracking-widest active:scale-95">
                            <i class="fas fa-trash-alt"></i>
                            Supprimer le rapport
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); }
</style>
@endsection
