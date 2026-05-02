@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.vehicules.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Fiche Véhicule : {{ $vehicule->immatriculation }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Marque & Modèle</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $vehicule->marque }} {{ $vehicule->modele }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Année</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $vehicule->annee }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Capacité</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $vehicule->capacite }} places</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <p class="font-bold text-lg text-gray-900 dark:text-white">{{ ucfirst($vehicule->statut) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
