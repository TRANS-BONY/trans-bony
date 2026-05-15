@extends('layouts.manager')

@section('content')
<div class="h-full flex flex-col space-y-4">
    <!-- En-tête Dynamique Premium -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-700 p-6 md:p-8 shadow-xl shrink-0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-5">
                <a href="{{ route('manager.rapports.index') }}" class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30 shadow-inner hover:scale-110 transition-transform">
                    <i class="fas fa-arrow-left text-white text-xl"></i>
                </a>
                <div>
                    <nav class="flex items-center gap-2 text-blue-100/70 text-[9px] uppercase font-black tracking-widest mb-1.5">
                        <a href="{{ route('manager.rapports.index') }}" class="hover:text-white transition-colors">Rapports</a>
                        <i class="fas fa-chevron-right text-[7px]"></i>
                        <span>Détails de l'analyse</span>
                    </nav>
                    <h1 class="text-xl md:text-2xl font-black text-white leading-tight tracking-tight">{{ $rapport->titre }}</h1>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/10 text-white text-[9px] font-black uppercase tracking-widest border border-white/20">
                            <i class="fas fa-hashtag opacity-50"></i>
                            REF-{{ str_pad($rapport->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="text-blue-100 text-[11px] font-bold uppercase tracking-widest">{{ $rapport->type }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 text-right">
                    <p class="text-[8px] text-blue-200 uppercase font-black leading-none">Généré le</p>
                    <p class="text-xs font-bold text-white mt-1">{{ $rapport->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone de Contenu Scrollable -->
    <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar pr-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-6">
            {{-- Left: Stats & Charts --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-emerald-500/5 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Recettes</p>
                        <p class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($rapport->recettes_total, 0, ',', ' ') }}</p>
                        <p class="text-[9px] text-gray-400 uppercase font-bold mt-1 tracking-tighter">Franc CFA</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-blue-500/5 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Voyages</p>
                        <p class="text-xl font-black text-blue-600 dark:text-blue-400">{{ $rapport->nb_voyages }}</p>
                        <p class="text-[9px] text-gray-400 uppercase font-bold mt-1">Total trajets</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-indigo-500/5 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Véhicules</p>
                        <p class="text-xl font-black text-indigo-600 dark:text-indigo-400">{{ $rapport->nb_vehicules }}</p>
                        <p class="text-[9px] text-gray-400 uppercase font-bold mt-1">Unités actives</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                        <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-purple-500/5 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Chauffeurs</p>
                        <p class="text-xl font-black text-purple-600 dark:text-purple-400">{{ $rapport->nb_chauffeurs }}</p>
                        <p class="text-[9px] text-gray-400 uppercase font-bold mt-1">Effectif</p>
                    </div>
                </div>

                {{-- Chart/Performance Card placeholder (could be an image or real chart) --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-chart-area text-blue-500"></i> Analyse de Performance de la Période
                        </h3>
                        <div class="flex gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500/20"></span>
                        </div>
                    </div>
                    
                    <div class="h-48 bg-gray-50 dark:bg-gray-900/50 rounded-2xl flex items-center justify-center border border-dashed border-gray-200 dark:border-gray-700 overflow-hidden relative">
                         <!-- Visual representation of performance -->
                         <div class="absolute inset-0 flex items-end justify-around px-8">
                            <div class="w-12 bg-blue-500/20 rounded-t-xl transition-all duration-1000" style="height: 40%"></div>
                            <div class="w-12 bg-blue-500/40 rounded-t-xl transition-all duration-1000" style="height: 70%"></div>
                            <div class="w-12 bg-blue-500 rounded-t-xl transition-all duration-1000" style="height: 100%"></div>
                            <div class="w-12 bg-blue-500/60 rounded-t-xl transition-all duration-1000" style="height: 55%"></div>
                         </div>
                         <div class="relative z-10 text-center">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Recettes</p>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($rapport->recettes_total, 0, ',', ' ') }} <span class="text-xs font-medium opacity-50">CFA</span></p>
                         </div>
                    </div>
                </div>

                {{-- Observations Section --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/20">
                        <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Notes & Observations Managériales</h3>
                        <i class="fas fa-quote-right text-blue-200 dark:text-gray-700"></i>
                    </div>
                    <div class="p-8">
                        @if($rapport->notes)
                            <div class="prose dark:prose-invert max-w-none">
                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed italic">"{{ $rapport->notes }}"</p>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-gray-400 italic gap-4">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900/50 rounded-full flex items-center justify-center shadow-inner">
                                    <i class="fas fa-comment-slash text-2xl opacity-20"></i>
                                </div>
                                <p class="text-xs font-bold uppercase tracking-widest">Aucune note stratégique enregistrée</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Technical Sidebar --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Fiche Technique --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Période d'Analyse</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-500">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-[8px] text-gray-400 uppercase font-black leading-none mb-1">Date de début</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $rapport->periode_debut->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center text-violet-500">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-[8px] text-gray-400 uppercase font-black leading-none mb-1">Date de fin</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $rapport->periode_fin->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-50 dark:border-gray-700 flex justify-between items-center">
                            <span class="text-[10px] text-gray-400 font-bold uppercase">Auteur</span>
                            <span class="text-xs font-black text-gray-900 dark:text-white">{{ $rapport->user->name ?? 'Système' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Export Tools --}}
                <div class="bg-gray-900 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <h3 class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-6 relative">Outils de Diffusion</h3>
                    
                    <div class="space-y-3 relative">
                        <button class="w-full flex items-center gap-4 p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all group/btn">
                            <div class="w-10 h-10 bg-red-500/20 text-red-400 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-xs font-bold text-white">Version PDF</p>
                                <p class="text-[9px] text-gray-500 uppercase font-black tracking-tighter mt-0.5">Pour impression</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-4 p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all group/btn">
                            <div class="w-10 h-10 bg-emerald-500/20 text-emerald-400 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-xs font-bold text-white">Analyse Excel</p>
                                <p class="text-[9px] text-gray-500 uppercase font-black tracking-tighter mt-0.5">Données brutes</p>
                            </div>
                        </button>
                    </div>
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
