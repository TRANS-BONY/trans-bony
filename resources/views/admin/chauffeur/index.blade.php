@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-600 via-emerald-600 to-green-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Gestion des Chauffeurs
                    </h1>
                    <p class="text-emerald-100 text-sm mt-1">Gérez votre personnel de conduite en toute sécurité</p>
                </div>
            </div>
            <a href="{{ route('admin.chauffeurs.create') }}"
               class="group relative overflow-hidden px-6 py-3 bg-white text-emerald-600 rounded-xl shadow-lg hover:bg-emerald-50 transition-all duration-300 hover:scale-105">
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-bold">Ajouter un chauffeur</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Barre de recherche (si vous souhaitez l'implémenter plus tard, elle garde le même format premium) -->
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
                           placeholder="Rechercher par nom, prénom, permis..."
                           value="{{ request('search') }}"
                           class="w-full p-3 bg-transparent text-gray-700 dark:text-gray-300 placeholder-gray-400 focus:outline-none">
                </form>
                @if(request('search'))
                <a href="{{ route('admin.chauffeurs.index') }}" class="pr-4">
                    <svg class="w-5 h-5 text-gray-400 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-100 uppercase tracking-wider">Total</p>
                    <p class="text-3xl font-bold text-white">{{ count($chauffeurs) }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider">Actifs</p>
                    <p class="text-3xl font-bold text-white">{{ $chauffeurs->where('actif', true)->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl bg-gradient-to-br from-red-500 to-red-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-red-100 uppercase tracking-wider">Inactifs</p>
                    <p class="text-3xl font-bold text-white">{{ $chauffeurs->where('actif', false)->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des chauffeurs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 animate-fade-in-up" style="animation-delay: 0.3s">
        @forelse($chauffeurs as $c)
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] flex flex-col">
            <div class="p-6 pb-4 flex items-start gap-4">
                <div class="relative">
                    <img src="{{ $c->photo ? asset('storage/'.$c->photo) : asset('images/default-user.png') }}"
                         class="w-16 h-16 rounded-2xl object-cover shadow-md border-2 border-white dark:border-gray-700">
                    <span class="absolute -bottom-1 -right-1 w-4 h-4 border-2 border-white dark:border-gray-800 rounded-full {{ $c->actif ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1">
                        {{ $c->nom }}
                    </h2>
                    <p class="text-md text-gray-600 dark:text-gray-300 truncate">
                        {{ $c->prenom }}
                    </p>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $c->actif ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                        {{ $c->actif ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex-1 border-t border-gray-100 dark:border-gray-700">
                <div class="space-y-2">
                    <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        <span class="truncate">Permis: <span class="font-semibold">{{ $c->permis ?: 'Non défini' }}</span></span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="truncate">{{ $c->telephone ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 flex justify-between items-center gap-2">
                <a href="{{ route('admin.chauffeurs.show', $c->id) }}" class="flex-1 text-center py-2 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl transition-colors font-medium text-sm">
                    <i class="fas fa-eye mr-1"></i> Voir
                </a>
                <a href="{{ route('admin.chauffeurs.edit', $c->id) }}" class="flex-1 text-center py-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl transition-colors font-medium text-sm">
                    <i class="fas fa-edit mr-1"></i> Éditer
                </a>
                <form method="POST" action="{{ route('admin.chauffeurs.destroy', $c->id) }}" class="flex-1" onsubmit="return confirm('Attention: Confirmer la suppression ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-center py-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-xl transition-colors font-medium text-sm">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-md">
                <div class="p-4 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <p class="text-lg font-bold text-gray-700 dark:text-white">Aucun chauffeur trouvé</p>
                <p class="text-gray-500 dark:text-gray-400 mt-1 mb-6 text-center max-w-md">Ajoutez des chauffeurs à votre flotte pour commencer à gérer vos conducteurs efficacement.</p>
                <a href="{{ route('admin.chauffeurs.create') }}" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full transition-colors font-bold shadow-lg">
                    <i class="fas fa-plus mr-2"></i> Ajouter un chauffeur
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection
