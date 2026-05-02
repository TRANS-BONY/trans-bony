@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.recettes.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détails de la Recette #{{ $recette->id }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Informations de la Recette</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Date</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $recette->date->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Véhicule</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $recette->vehicule->immatriculation ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Montant</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ number_format($recette->montant, 0, ',', ' ') }} FCFA</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Type</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $recette->type }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
