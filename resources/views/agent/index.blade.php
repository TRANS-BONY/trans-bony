@extends('layouts.agent')

@section('content')
<style>
    /* Désactiver le scroll global sur le tableau de bord */
    html, body { overflow: hidden !important; height: 100vh !important; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>

<div class="flex flex-col gap-4 h-[calc(100vh-100px)] overflow-hidden pb-2">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-600 p-4 animate-slide-down shadow-xl shrink-0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm hidden sm:block">
                    <i class="fas fa-hand-sparkles text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Bienvenue, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-blue-100 text-xs mt-0.5">Espace de gestion et de planification</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-lg backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-[10px] text-white">Serveur actif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 shrink-0">
        <div class="rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 shadow-md hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-indigo-100 uppercase tracking-wider font-semibold">Total Voyages</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-route text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ number_format($voyages ?? 0, 0, ',', ' ') }}</p>
            <p class="text-[10px] text-indigo-200 mt-1">Enregistrés</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-4 shadow-md hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Véhicules</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-car text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ number_format($vehicules ?? 0, 0, ',', ' ') }}</p>
            <p class="text-[10px] text-blue-200 mt-1">Dans la flotte</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-sky-500 to-sky-600 p-4 shadow-md hover:scale-[1.02] transition-transform">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] text-sky-100 uppercase tracking-wider font-semibold">Chauffeurs</p>
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center">
                    <i class="fas fa-id-card text-white text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">{{ number_format($chauffeurs ?? 0, 0, ',', ' ') }}</p>
            <p class="text-[10px] text-sky-200 mt-1">Total actifs</p>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="flex-1 min-h-0 animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 h-full flex flex-col">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 font-semibold text-gray-800 dark:text-gray-200 shrink-0 text-sm">
                Accès rapide
            </div>
            <div class="p-4 flex-1 overflow-y-auto">
                <a href="{{ route('agent.voyages') }}" class="group flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white dark:bg-gray-600 rounded-full flex items-center justify-center shadow-sm text-blue-500 group-hover:scale-110 transition">
                            <i class="fas fa-route text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 dark:text-white group-hover:text-blue-600 transition">Gérer les voyages</h3>
                            <p class="text-[10px] text-gray-500">Planifier et suivre les voyages des véhicules</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-blue-500 transition text-sm"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
