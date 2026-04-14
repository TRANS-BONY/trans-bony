@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-600 via-gray-600 to-zinc-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Détails du Chauffeur
                    </h1>
                    <p class="text-gray-200 text-sm mt-1">Consultez en détail le dossier de ce chauffeur</p>
                </div>
            </div>
            <a href="{{ route('admin.chauffeurs.index') }}"
               class="group px-6 py-3 bg-white/10 hover:bg-white/20 border border-transparent hover:border-white/30 rounded-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm">
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="text-white font-medium">Retour à la liste</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Contenu Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Carte Profil -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 col-span-1 flex flex-col">
            <div class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 p-8 flex flex-col items-center">
                <div class="relative mb-4">
                    <img src="{{ $chauffeur->photo ? asset('storage/'.$chauffeur->photo) : asset('images/default-user.png') }}"
                         class="w-32 h-32 rounded-full object-cover shadow-2xl border-4 border-white dark:border-gray-800">
                    <span class="absolute bottom-1 right-2 w-5 h-5 border-2 border-white dark:border-gray-800 rounded-full {{ $chauffeur->actif ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
                    {{ $chauffeur->nom }} {{ $chauffeur->prenom }}
                </h2>
                <div class="mt-4 inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold {{ $chauffeur->actif ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                    <span class="w-2 h-2 rounded-full mr-2 {{ $chauffeur->actif ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                    {{ $chauffeur->actif ? 'Statut Actif' : 'Statut Inactif' }}
                </div>
            </div>

            <div class="p-6 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex-1">
                <a href="{{ route('admin.chauffeurs.edit', $chauffeur) }}"
                   class="flex w-full justify-center items-center gap-2 px-6 py-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl transition-all font-bold">
                    <i class="fas fa-edit"></i> Modifier le profil
                </a>
            </div>
        </div>

        <!-- Détails Professionnels -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 col-span-1 lg:col-span-2 p-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                Informations Complètes
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bloc Permis -->
                <div class="space-y-1">
                    <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Catégorie de Permis
                    </div>
                    <p class="text-xl font-bold text-gray-900 dark:text-white pl-6">
                        {{ $chauffeur->permis ?? 'Non renseigné' }}
                    </p>
                </div>

                <!-- Bloc Téléphone -->
                <div class="space-y-1">
                    <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Numéro de Téléphone
                    </div>
                    <p class="text-xl font-bold text-gray-900 dark:text-white pl-6">
                        {{ $chauffeur->telephone ?? 'Non renseigné' }}
                    </p>
                </div>
            </div>
            
            <div class="mt-12 pt-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-6">
                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Il s'agit des informations d'identité certifiées du chauffeur. Si des incohérences sont constatées, veuillez procéder à une modification du profil.
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection
