@extends('layouts.gestionnaire')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <i class="fas fa-bus text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['vehicules'] }}</span>
            </div>
            <p class="text-sm text-gray-500">Véhicules enregistrés</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                    <i class="fas fa-id-card text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['chauffeurs'] }}</span>
            </div>
            <p class="text-sm text-gray-500">Chauffeurs actifs</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['documents'] }}</span>
            </div>
            <p class="text-sm text-gray-500">Documents totaux</p>
            @if($stats['documents_expirant'] > 0)
                <p class="text-[10px] text-red-500 font-bold mt-1 uppercase">{{ $stats['documents_expirant'] }} expireront bientôt</p>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                    <i class="fas fa-tools text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['maintenances_en_cours'] }}</span>
            </div>
            <p class="text-sm text-gray-500">Maintenances en cours</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-gray-900 dark:text-white mb-6">Derniers véhicules ajoutés</h3>
            <div class="space-y-4">
                @foreach($derniers_vehicules as $v)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-bus text-teal-500"></i>
                            <div>
                                <p class="text-sm font-bold">{{ $v->immatriculation }}</p>
                                <p class="text-xs text-gray-500">{{ $v->marque }} {{ $v->modele }}</p>
                            </div>
                        </div>
                        <a href="{{ route('gestionnaire.vehicules.show', $v) }}" class="text-teal-600 text-xs font-bold">Voir</a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-gray-900 dark:text-white mb-6">Derniers chauffeurs ajoutés</h3>
            <div class="space-y-4">
                @foreach($derniers_chauffeurs as $c)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-user text-yellow-500"></i>
                            <div>
                                <p class="text-sm font-bold">{{ $c->nom }} {{ $c->prenom }}</p>
                                <p class="text-xs text-gray-500">{{ $c->telephone }}</p>
                            </div>
                        </div>
                        <a href="{{ route('gestionnaire.chauffeurs.show', $c) }}" class="text-teal-600 text-xs font-bold">Voir</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
