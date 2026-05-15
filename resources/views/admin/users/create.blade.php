@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-user-plus text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Ajouter un Utilisateur</h1>
                    <p class="text-indigo-100 text-sm mt-1">Créez un nouveau compte utilisateur</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="group px-6 py-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm text-white font-medium flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-transparent dark:border-gray-700 p-8 animate-fade-in-up">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Jean Dupont" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    @error('name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Ex: jean@transbony.com" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    @error('email') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    @error('password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500">Min 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 symbole.</p>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirmer mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Rôle <span class="text-red-500">*</span></label>
                    <select name="role_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="">Sélectionner un rôle</option>
                        @foreach($roles as $id => $name)
                            <option value="{{ $id }}" {{ old('role_id') == $id ? 'selected' : '' }}>{{ ucfirst($name) }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                    <select name="is_active" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>🟢 Actif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>🔴 Inactif</option>
                    </select>
                    @error('is_active') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                    Enregistrer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

