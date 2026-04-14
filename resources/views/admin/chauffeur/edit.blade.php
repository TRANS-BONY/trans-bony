@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Éditer un Chauffeur
                    </h1>
                    <p class="text-indigo-100 text-sm mt-1">Mettez à jour le profil de {{ $chauffeur->prenom }} {{ $chauffeur->nom }}</p>
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

    <!-- Formulaire d'édition -->
    <div class="animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-transparent dark:border-gray-700">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Identité et informations professionnelles</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Modifiez les champs selon vos besoins</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.chauffeurs.update', $chauffeur->id) }}" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nom" value="{{ old('nom', $chauffeur->nom) }}" 
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('nom') border-red-500 @enderror"
                               required>
                        @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Prénom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="prenom" value="{{ old('prenom', $chauffeur->prenom) }}" 
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('prenom') border-red-500 @enderror"
                               required>
                        @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Permis -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Catégorie de Permis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="permis" value="{{ old('permis', $chauffeur->permis) }}"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('permis') border-red-500 @enderror"
                               required>
                        @error('permis') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Téléphone
                        </label>
                        <input type="text" name="telephone" value="{{ old('telephone', $chauffeur->telephone) }}"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('telephone') border-red-500 @enderror">
                        @error('telephone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Photo de Profil -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Photo de Profil
                        </label>
                        <div class="flex items-center gap-4">
                            @if($chauffeur->photo)
                                <img src="{{ asset('storage/'.$chauffeur->photo) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm bg-gray-100 dark:bg-gray-700" alt="Photo Actuelle">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 shadow-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <input type="file" name="photo" accept="image/*"
                                   class="flex-1 px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white cursor-pointer file:cursor-pointer file:border-0 file:bg-indigo-100 file:dark:bg-indigo-900/50 file:text-indigo-700 file:dark:text-indigo-400 file:px-4 file:py-2 file:rounded-full file:-ml-2 file:mr-4 hover:file:bg-indigo-200">
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Laissez vide si vous ne souhaitez pas modifier l'image actuelle.</p>
                        @error('photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Actif/Inactif -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="actif"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 dark:text-white appearance-none cursor-pointer"
                                    required>
                                <option value="1" {{ old('actif', $chauffeur->actif) == '1' ? 'selected' : '' }}>🟢 Actif</option>
                                <option value="0" {{ old('actif', $chauffeur->actif) == '0' ? 'selected' : '' }}>🔴 Inactif</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('actif') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                            class="group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-lg transition-all duration-300 hover:scale-105 flex-1 font-bold">
                        <div class="relative flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Mettre à jour le profil 
                        </div>
                    </button>
                    <a href="{{ route('admin.chauffeurs.index') }}"
                       class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg transition-all duration-300 hover:scale-105 text-center flex-1 font-bold">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    input:focus, select:focus { outline: none; }
</style>
@endsection
