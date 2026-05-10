@extends('layouts.gestionnaire')

@section('title', 'Tableau de bord')

@section('content')
<style>
    /* Désactiver le scroll global sur le tableau de bord */
    html, body { overflow: hidden !important; height: 100vh !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
</style>

<div class="flex flex-col gap-4 h-[calc(100vh-100px)] overflow-hidden pb-2">
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 shrink-0">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-xl">
                    <i class="fas fa-bus text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['vehicules'] }}</span>
            </div>
            <p class="text-xs text-gray-500">Véhicules enregistrés</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-xl">
                    <i class="fas fa-id-card text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['chauffeurs'] }}</span>
            </div>
            <p class="text-xs text-gray-500">Chauffeurs actifs</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                    <i class="fas fa-file-alt text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['documents'] }}</span>
            </div>
            <p class="text-xs text-gray-500">Documents totaux</p>
            @if($stats['documents_expirant'] > 0)
                <p class="text-[9px] text-red-500 font-bold mt-1 uppercase">{{ $stats['documents_expirant'] }} expireront bientôt</p>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-orange-50 text-orange-600 rounded-xl">
                    <i class="fas fa-tools text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['maintenances_en_cours'] }}</span>
            </div>
            <p class="text-xs text-gray-500">Maintenances en cours</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 flex-1 min-h-0">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col min-h-0">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-3 shrink-0">Derniers véhicules ajoutés</h3>
            <div class="space-y-3 overflow-y-auto custom-scrollbar flex-1 min-h-0 pr-2">
                @foreach($derniers_vehicules as $v)
                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-bus text-teal-500"></i>
                            <div>
                                <p class="text-xs font-bold">{{ $v->immatriculation }}</p>
                                <p class="text-[10px] text-gray-500">{{ $v->marque }} {{ $v->modele }}</p>
                            </div>
                        </div>
                        <a href="{{ route('gestionnaire.vehicules.show', $v) }}" class="text-teal-600 text-[10px] px-2 py-1 bg-teal-50 rounded-md font-bold">Voir</a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col min-h-0">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-3 shrink-0">Derniers chauffeurs ajoutés</h3>
            <div class="space-y-3 overflow-y-auto custom-scrollbar flex-1 min-h-0 pr-2">
                @foreach($derniers_chauffeurs as $c)
                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-user text-yellow-500"></i>
                            <div>
                                <p class="text-xs font-bold">{{ $c->nom }} {{ $c->prenom }}</p>
                                <p class="text-[10px] text-gray-500">{{ $c->telephone }}</p>
                            </div>
                        </div>
                        <a href="{{ route('gestionnaire.chauffeurs.show', $c) }}" class="text-teal-600 text-[10px] px-2 py-1 bg-teal-50 rounded-md font-bold">Voir</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
