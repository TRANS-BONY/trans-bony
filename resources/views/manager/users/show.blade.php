@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.users.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Fiche Utilisateur : {{ $user->name }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nom Complet</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Rôle</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ ucfirst($user->role) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date d'Inscription</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut Compte</p>
                <span class="px-2 py-1 text-xs font-semibold rounded-lg {{ $user->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $user->active ? 'Actif' : 'Désactivé' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
