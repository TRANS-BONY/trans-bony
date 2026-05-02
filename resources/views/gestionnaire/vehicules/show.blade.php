@extends('layouts.gestionnaire')

@section('title', 'Détails Véhicule')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('gestionnaire.vehicules.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-teal-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $vehicule->immatriculation }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-4 text-center md:text-left">
                <div class="w-24 h-24 mx-auto md:mx-0 bg-teal-50 dark:bg-teal-900/20 text-teal-600 rounded-2xl flex items-center justify-center text-4xl">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold">{{ $vehicule->marque }} {{ $vehicule->modele }}</h3>
                    <p class="text-gray-500 text-sm">Parc Automobile</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <span class="text-sm text-gray-500 font-medium">Année</span>
                    <span class="text-sm font-bold">{{ $vehicule->annee }}</span>
                </div>
                <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <span class="text-sm text-gray-500 font-medium">Capacité</span>
                    <span class="text-sm font-bold">{{ $vehicule->capacite }} places</span>
                </div>
                <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <span class="text-sm text-gray-500 font-medium">Statut</span>
                    <span class="text-sm font-bold uppercase">{{ $vehicule->statut }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl text-center">
                    <p class="text-2xl font-bold">{{ $vehicule->voyages_count }}</p>
                    <p class="text-[10px] font-bold uppercase">Voyages</p>
                </div>
                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 text-orange-600 rounded-2xl text-center">
                    <p class="text-2xl font-bold">{{ $vehicule->maintenances_count }}</p>
                    <p class="text-[10px] font-bold uppercase">Entretiens</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
