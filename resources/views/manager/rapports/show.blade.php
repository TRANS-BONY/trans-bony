@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.rapports.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détails du Rapport #{{ $rapport->id }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Informations du Rapport</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Titre</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $rapport->titre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Type</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ ucfirst($rapport->type) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Période</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $rapport->periode_debut->format('d/m/Y') }} - {{ $rapport->periode_fin->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Auteur</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $rapport->user->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Statistiques du Rapport</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Total Recettes</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ number_format($rapport->recettes_total ?? 0, 0, ',', ' ') }} Franc CFA</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Nombre de Voyages</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $rapport->nb_voyages ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Véhicules Actifs</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $rapport->nb_vehicules ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Chauffeurs Actifs</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $rapport->nb_chauffeurs ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
    
    @if($rapport->notes)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Notes & Observations</h3>
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $rapport->notes }}</p>
    </div>
    @endif
</div>
@endsection
