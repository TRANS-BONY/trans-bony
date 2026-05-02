@extends('layouts.technicien')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('technicien.vehicules.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-orange-600 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Fiche Véhicule : {{ $vehicule->immatriculation }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- INFO VEHICULE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center text-3xl">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $vehicule->marque }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $vehicule->modele }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Statut</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-lg
                        {{ $vehicule->statut == 'disponible' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $vehicule->statut == 'en voyage' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $vehicule->statut == 'en maintenance' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $vehicule->statut == 'indisponible' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($vehicule->statut) }}
                    </span>
                </div>
                <div class="flex justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Année</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $vehicule->annee }}</span>
                </div>
                <div class="flex justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Capacité</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $vehicule->capacite }} places</span>
                </div>
            </div>
        </div>

        {{-- HISTORIQUE MAINTENANCES --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Historique des Maintenances</h3>
                <a href="{{ route('technicien.maintenances.create') }}" class="text-sm bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition font-medium">
                    <i class="fas fa-plus mr-1"></i> Ajouter
                </a>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                            <th class="p-4 font-medium">Date Prévue</th>
                            <th class="p-4 font-medium">Type</th>
                            <th class="p-4 font-medium">Statut</th>
                            <th class="p-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                        @forelse($vehicule->maintenances as $m)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="p-4 text-gray-900 dark:text-white font-medium">{{ $m->date_prevue->format('d/m/Y') }}</td>
                            <td class="p-4 text-gray-500 dark:text-gray-400">{{ ucfirst($m->type) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg
                                    {{ $m->statut == 'terminee' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $m->statut == 'en cours' ? 'bg-orange-100 text-orange-700' : '' }}
                                    {{ $m->statut == 'planifiee' ? 'bg-blue-100 text-blue-700' : '' }}">
                                    {{ ucfirst($m->statut) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('technicien.maintenances.show', $m) }}" class="text-gray-400 hover:text-blue-600 transition p-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-tools text-3xl mb-3 opacity-50"></i>
                                <p>Aucune maintenance enregistrée pour ce véhicule.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
