@extends('layouts.technicien')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('technicien.maintenances.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-orange-600 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détails de la Maintenance #{{ $maintenance->id }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('technicien.maintenances.edit', $maintenance) }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 font-medium rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm transition">
                <i class="fas fa-edit"></i> Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- INFO MAINTENANCE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl
                    {{ $maintenance->statut == 'termine' ? 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400' : '' }}
                    {{ $maintenance->statut == 'en_cours' ? 'bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400' : '' }}
                    {{ $maintenance->statut == 'planifie' ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : '' }}
                    {{ $maintenance->statut == 'annule' ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400' : '' }}">
                    <i class="fas fa-tools"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Intervention {{ ucfirst($maintenance->type) }}</h2>
                    <span class="inline-block mt-1 px-2.5 py-1 text-xs font-semibold rounded-lg
                        {{ $maintenance->statut == 'termine' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $maintenance->statut == 'en_cours' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $maintenance->statut == 'planifie' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $maintenance->statut == 'annule' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $maintenance->statut)) }}
                    </span>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Date Prévue</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $maintenance->date_prevue->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Coût estimé / réel</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ $maintenance->cout ? number_format($maintenance->cout, 0, ',', ' ') . ' Franc CFA' : 'Non défini' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Date d'enregistrement</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $maintenance->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- INFO VEHICULE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Véhicule Concerné</h3>
            
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 dark:text-white text-lg">{{ $maintenance->vehicule?->immatriculation ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $maintenance->vehicule?->marque ?? '' }} {{ $maintenance->vehicule?->modele ?? '' }}</p>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Statut du véhicule</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $maintenance->vehicule ? ucfirst($maintenance->vehicule->statut) : 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Année</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $maintenance->vehicule?->annee ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Capacité</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $maintenance->vehicule?->capacite ?? '?' }} places</span>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('technicien.vehicules.show', $maintenance->vehicule_id) }}" class="flex items-center justify-center gap-2 w-full py-2.5 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition">
                    Voir la fiche complète
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
