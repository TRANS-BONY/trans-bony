@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Détails Véhicule</h1>
                <p class="text-emerald-100 mt-1">{{ $vehicule->immatriculation }}</p>
            </div>
            <div class="ml-auto flex gap-3">
                <a href="{{ route('admin.vehicules.edit', $vehicule) }}" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.vehicules.index') }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Liste
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informations principales -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Fiche technique</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Immatriculation</label>
                        <div class="text-3xl font-bold text-emerald-600">{{ $vehicule->immatriculation }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Marque</label>
                        <div class="font-semibold text-gray-900">{{ $vehicule->marque }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Modèle</label>
                        <div class="font-semibold text-gray-900">{{ $vehicule->modele }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Année</label>
                        <div class="font-semibold text-gray-900">{{ $vehicule->annee }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Capacité</label>
                        <div class="font-semibold text-gray-900">{{ $vehicule->capacite }} places</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Statut</label>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800">
                            {{ ucfirst($vehicule->statut) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statut et métriques -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">État du véhicule</h3>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl">
                    <div class="p-3 bg-emerald-200 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">Statut actuel : {{ ucfirst($vehicule->statut) }}</p>
                        <p class="text-sm text-gray-600">Disponible pour {{ $vehicule->statut == 'disponible' ? 'toutes missions' : 'vérification avant utilisation' }}</p>
                    </div>
                </div>

                @if($vehicule->voyages_count > 0)
                <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-200 rounded-lg">
                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Voyages effectués</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $vehicule->voyages_count }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($vehicule->maintenances_count > 0)
                <div class="p-4 bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl border border-amber-200">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-200 rounded-lg">
                            <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-amber-900">Maintenances</p>
                            <p class="text-2xl font-bold text-amber-700">{{ $vehicule->maintenances_count }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Historique récent -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
            <h3 class="text-xl font-semibold text-gray-800">Historique récent</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @if($vehicule->voyages->count() > 0)
            @foreach($vehicule->voyages->take(5) as $voyage)
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">Voyage {{ $voyage->id }}</p>
                        <p class="text-sm text-gray-500">{{ $voyage->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="p-12 text-center">
                <p class="text-gray-500">Aucun voyage pour ce véhicule</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.btn-primary {
    @apply bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center;
}
.btn-secondary {
    @apply bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center;
}
</style>
@endsection
