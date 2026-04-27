@extends('layouts.agent')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-hand-sparkles text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Bienvenue, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-blue-100 text-sm mt-1">Espace de gestion et de planification</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs text-white">Serveur actif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="card-hover rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-100 uppercase tracking-wider font-semibold">Total Voyages</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($voyages ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-indigo-200">Enregistrés</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-route text-white text-xl"></i></div>
            </div>
        </div>
        <div class="card-hover rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-100 uppercase tracking-wider font-semibold">Véhicules</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($vehicules ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-blue-200">Dans la flotte</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-car text-white text-xl"></i></div>
            </div>
        </div>
        <div class="card-hover rounded-2xl bg-gradient-to-br from-sky-500 to-sky-600 p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-sky-100 uppercase tracking-wider font-semibold">Chauffeurs</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($chauffeurs ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-xs text-sky-200">Total actifs</p>
                </div>
                <div class="p-3 rounded-xl bg-white/20"><i class="fas fa-id-card text-white text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="grid grid-cols-1 gap-6 animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 font-semibold text-gray-800 dark:text-gray-200">
                Accès rapide
            </div>
            <div class="p-6">
                <a href="{{ route('agent.voyages') }}" class="group flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white dark:bg-gray-600 rounded-full flex items-center justify-center shadow-sm text-blue-500 group-hover:scale-110 transition">
                            <i class="fas fa-route"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white group-hover:text-blue-600 transition">Gérer les voyages</h3>
                            <p class="text-sm text-gray-500">Planifier et suivre les voyages des véhicules</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-blue-500 transition"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
