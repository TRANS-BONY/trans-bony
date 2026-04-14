@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Gestion des Véhicules
                    </h1>
                    <p class="text-indigo-100 text-sm mt-1">Gérez votre flotte automobile en toute simplicité</p>
                </div>
            </div>
            <a href="{{ route('admin.vehicules.create') }}"
               class="group relative overflow-hidden px-6 py-3 bg-emerald-500 rounded-xl shadow-lg hover:bg-emerald-600 transition-all duration-300 hover:scale-105">
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-white font-medium">Ajouter un véhicule</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="relative animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md">
            <div class="relative flex items-center">
                <div class="pl-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <form method="GET" class="flex-1">
                    <input type="text"
                           name="search"
                           placeholder="Rechercher par immatriculation, marque, modèle..."
                           value="{{ request('search') }}"
                           class="w-full p-3 bg-transparent text-gray-700 dark:text-gray-300 placeholder-gray-400 focus:outline-none">
                </form>
                @if(request('search'))
                <a href="{{ route('admin.vehicules.index') }}" class="pr-4">
                    <svg class="w-5 h-5 text-gray-400 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistiques rapides des véhicules -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.2s">
        <!-- Total Véhicules -->
        <div class="rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-100 uppercase tracking-wider">Total</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Disponibles -->
        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider">Disponibles</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->where('statut', 'disponible')->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- En mission -->
        <div class="rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-sky-100 uppercase tracking-wider">En mission</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->where('statut', 'mission')->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Maintenance -->
        <div class="rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider">Maintenance</p>
                    <p class="text-3xl font-bold text-white">{{ $vehicules->where('statut', 'maintenance')->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des véhicules -->
    <div class="rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg animate-fade-in-up" style="animation-delay: 0.3s">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Immatriculation</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Marque</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Modèle</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Année</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Capacité</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($vehicules as $v)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 group">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $v->immatriculation }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $v->marque }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $v->modele }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $v->annee }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $v->capacite }} pers.</span>
                            </div>
                        </td>
                        <td class="p-4">
                            @php
                                $statusConfig = [
                                    'disponible' => ['bg' => 'bg-emerald-500', 'text' => 'text-white', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Disponible'],
                                    'mission' => ['bg' => 'bg-sky-500', 'text' => 'text-white', 'icon' => 'M13 7l5 5m0 0l-5 5m5-5H6', 'label' => 'En mission'],
                                    'maintenance' => ['bg' => 'bg-amber-500', 'text' => 'text-white', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'label' => 'Maintenance']
                                ];
                                $config = $statusConfig[$v->statut] ?? $statusConfig['disponible'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                </svg>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.vehicules.show', $v->id) }}"
                                   class="group p-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-all duration-300 hover:scale-110"
                                   title="Voir les détails">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.vehicules.edit', $v->id) }}"
                                   class="group p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 hover:scale-110"
                                   title="Modifier">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.vehicules.destroy', $v->id) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce véhicule ?')"
                                            class="p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-all duration-300 hover:scale-110"
                                            title="Supprimer">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="p-4 rounded-full bg-gray-100 dark:bg-gray-700">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Aucun véhicule trouvé</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        @if(request('search'))
                                            Aucun résultat pour "{{ request('search') }}"
                                        @else
                                            Commencez par ajouter un véhicule à votre flotte
                                        @endif
                                    </p>
                                </div>
                                @if(!request('search'))
                                <a href="{{ route('admin.vehicules.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all duration-300 hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Ajouter un véhicule
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-down {
        animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Animation pour les lignes du tableau */
    tbody tr {
        animation: fadeInUp 0.4s ease-out forwards;
        opacity: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation de transition pour les lignes du tableau avec délais progressifs
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
    });
</script>

@endsection

