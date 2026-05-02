@extends('layouts.gestionnaire')

@section('title', 'Détails Maintenance')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('gestionnaire.maintenances.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-teal-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Intervention #{{ $maintenance->id }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="p-6 bg-teal-50 dark:bg-teal-900/20 rounded-2xl">
                    <p class="text-[10px] text-teal-600 font-bold uppercase mb-1">Véhicule</p>
                    <p class="text-lg font-bold">{{ $maintenance->vehicule->immatriculation ?? 'N/A' }}</p>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <span class="text-sm text-gray-500 font-medium">Type d'intervention</span>
                        <span class="text-sm font-bold">{{ $maintenance->type }}</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <span class="text-sm text-gray-500 font-medium">Date prévue</span>
                        <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <span class="text-sm text-gray-500 font-medium">Statut</span>
                        <span class="text-sm font-bold uppercase">{{ $maintenance->statut }}</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <span class="text-sm text-gray-500 font-medium">Coût estimé</span>
                        <span class="text-sm font-bold">{{ number_format($maintenance->cout, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-700/50 rounded-3xl p-8">
                <i class="fas fa-tools text-6xl text-teal-500 mb-4 opacity-20"></i>
                <p class="text-sm text-gray-400 font-medium text-center">Les détails techniques complets sont gérés par le module technique.</p>
            </div>
        </div>
    </div>
</div>
@endsection
