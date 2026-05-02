@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.voyages.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détails du Voyage #{{ $voyage->id }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Informations de Trajet</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Ville de Départ</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $voyage->ville_depart }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Ville d'Arrivée</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $voyage->ville_arrivee }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date de Départ</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $voyage->date_depart->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date d'Arrivée Prévue</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $voyage->date_arrivee ? $voyage->date_arrivee->format('d/m/Y H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Statut</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ ucfirst($voyage->statut) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Véhicule & Chauffeur</h3>
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Véhicule</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $voyage->vehicule->immatriculation ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400">{{ $voyage->vehicule->marque ?? '' }} {{ $voyage->vehicule->modele ?? '' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Chauffeur</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $voyage->chauffeur->nom ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400">{{ $voyage->chauffeur->telephone ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
