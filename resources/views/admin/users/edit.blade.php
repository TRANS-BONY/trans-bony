@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-user-edit text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Modifier l'Utilisateur</h1>
                    <p class="text-blue-100 text-sm mt-1">Modifiez les informations du compte de {{ $user->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="group px-6 py-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm text-white font-medium flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-transparent dark:border-gray-700 p-8 animate-fade-in-up">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nom complet <span class="text-gray-400 text-xs">(Non modifiable)</span></label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400 cursor-not-allowed" disabled>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-gray-400 text-xs">(Non modifiable)</span></label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400 cursor-not-allowed" disabled>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Mot de passe <span class="text-gray-400 text-xs">(Non modifiable ici)</span></label>
                    <input type="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400 cursor-not-allowed" disabled>
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Rôle <span class="text-red-500">*</span></label>
                    <select name="role_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all" required>
                        <option value="">Sélectionner un rôle</option>
                        @foreach($roles as $id => $name)
                            <option value="{{ $id }}" {{ old('role_id', $user->roles->first()?->id) == $id ? 'selected' : '' }}>{{ ucfirst($name) }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                    <select name="is_active" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>🟢 Actif</option>
                        <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>🔴 Inactif</option>
                    </select>
                    @error('is_active') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                    Mettre à jour l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

