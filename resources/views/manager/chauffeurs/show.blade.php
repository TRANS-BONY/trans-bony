@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.chauffeurs.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Fiche Chauffeur : {{ $chauffeur->nom }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nom</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->nom }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Prénom</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->prenom }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Téléphone</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->telephone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Contact d'urgence</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->contact ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Numéro de Permis</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white font-mono">{{ $chauffeur->permis }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-lg
                    {{ $chauffeur->actif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $chauffeur->actif ? 'Actif' : 'Inactif' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
