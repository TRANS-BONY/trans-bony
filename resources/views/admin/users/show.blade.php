@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-2xl p-8 mb-8 text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=3b82f6&background=f8fafc&size=128&bold=true' }}"
                         alt="{{ $user->name }}"
                         class="w-32 h-32 rounded-full ring-4 ring-white/30 shadow-2xl object-cover">
                    <div class="absolute -bottom-1 -right-1 bg-green-400 w-8 h-8 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                        <i class="fas fa-circle text-xs text-white {{ $user->is_active ? '' : 'opacity-30' }}"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-4xl font-bold mb-2 leading-tight">{{ $user->name }}</h1>
                    <p class="text-xl opacity-90 font-medium">{{ $user->email }}</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}"
               class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center gap-2 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Section principale -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                <i class="fas fa-user text-blue-500"></i>
                Informations principales
            </h2>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ID</label>
                        <p class="text-2xl font-mono bg-gray-50 dark:bg-gray-900 px-6 py-3 rounded-xl border">{{ $user->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                        <span class="inline-flex items-center px-6 py-3 rounded-2xl text-lg font-semibold bg-gradient-to-r
                            {{ $user->is_active ? 'from-green-400 to-green-500 text-white shadow-lg shadow-green-200' : 'from-red-400 to-red-500 text-white shadow-lg shadow-red-200' }}">
                            <i class="fas {{ $user->is_active ? 'fa-check-circle mr-2' : 'fa-times-circle mr-2' }}"></i>
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Inscrit le</label>
                    <p class="text-xl">{{ $user->created_at->format('d F Y à H:i') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Dernière mise à jour</label>
                    <p class="text-xl">{{ $user->updated_at->format('d F Y à H:i') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        <!-- Rôles et permissions -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                <i class="fas fa-shield-alt text-purple-500"></i>
                Rôles & Permissions
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Rôles assignés</label>
                    <div class="flex flex-wrap gap-3">
                        @forelse($user->roles as $userRole)
                            <span class="px-6 py-3 rounded-2xl bg-gradient-to-r font-semibold text-white shadow-lg
                                {{ $userRole->name == 'admin' ? 'from-purple-500 to-purple-600' : ($userRole->name == 'gestionnaire' ? 'from-blue-500 to-blue-600' : 'from-indigo-500 to-indigo-600') }}">
                                {{ ucfirst($userRole->name) }}
                            </span>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 italic px-4 py-3 bg-gray-100 dark:bg-gray-900 rounded-xl">Aucun rôle</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 mt-8 border border-gray-100 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <i class="fas fa-cogs text-orange-500"></i>
            Actions rapides
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.users.edit', $user) }}"
               class="group bg-blue-500 hover:bg-blue-600 text-white p-8 rounded-2xl text-center transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-2 flex flex-col items-center gap-3">
                <i class="fas fa-edit text-3xl group-hover:scale-110 transition"></i>
                <span class="font-semibold text-lg">Modifier</span>
            </a>
            <div class="group bg-green-500 hover:bg-green-600 text-white p-8 rounded-2xl text-center transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-2 flex flex-col items-center gap-3 cursor-default opacity-60">
                <i class="fas fa-eye text-3xl"></i>
                <span class="font-semibold text-lg">Voir (actuel)</span>
            </div>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="md:col-span-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full group bg-red-500 hover:bg-red-600 text-white p-8 rounded-2xl text-center transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-2 flex flex-col items-center gap-3">
                    <i class="fas fa-trash text-3xl group-hover:scale-110 transition"></i>
                    <span class="font-semibold text-lg">Supprimer</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Polish pour dates françaises */
    .fr-date { font-variant-numeric: tabular-nums; }
</style>
@endsection

