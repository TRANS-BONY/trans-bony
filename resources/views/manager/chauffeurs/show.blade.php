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
                <p class="text-sm text-gray-500">Nom Complet</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->nom }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Téléphone</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->telephone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Numéro de Permis</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $chauffeur->numero_permis }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ ucfirst($chauffeur->statut) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
