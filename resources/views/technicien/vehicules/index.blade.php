@extends('layouts.technicien')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Parc Automobile</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultation de l'état des véhicules</p>
        </div>
    </div>

    {{-- GRILLE VEHICULES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($vehicules as $vehicule)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl">
                            <i class="fas fa-bus"></i>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg
                            {{ $vehicule->statut == 'disponible' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $vehicule->statut == 'en voyage' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $vehicule->statut == 'en maintenance' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $vehicule->statut == 'indisponible' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($vehicule->statut) }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $vehicule->marque }} {{ $vehicule->modele }}</h3>
                    <p class="text-sm font-mono text-gray-500 dark:text-gray-400 mb-4">{{ $vehicule->immatriculation }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Année</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vehicule->annee }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Capacité</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vehicule->capacite }} pl.</p>
                        </div>
                    </div>

                    <a href="{{ route('technicien.vehicules.show', $vehicule) }}" class="block w-full py-2.5 text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white text-sm font-semibold rounded-xl transition">
                        Voir détails & Maintenances
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 mb-4">
                    <i class="fas fa-bus text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun véhicule</h3>
                <p class="text-gray-500 mt-1">Le parc est vide.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($vehicules->hasPages())
        <div class="mt-6">
            {{ $vehicules->links() }}
        </div>
    @endif

</div>
@endsection
