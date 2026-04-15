@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Détails Recette
                    </h1>
                    <p class="text-emerald-100">Mois : {{ \Carbon\Carbon::parse($recette->mois)->format('F Y') }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.recettes.edit', $recette) }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.recettes.index') }}" class="btn-secondary">\n                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor">\n                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>\n                    </svg>\n                    Liste\n                </a>
            </div>
        </div>
    </div>

    <!-- Main Info Card -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Informations principales</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Montant</label>
                        <div class="text-3xl font-bold text-emerald-600">{{ number_format($recette->montant, 2) }} XFA</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Mois</label>
                        <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($recette->mois)->format('MMMM YYYY') }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Date</label>
                        <div class="font-semibold text-gray-900">{{ $recette->date?->format('d/m/Y') }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-2">Type</label>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800">
                            {{ ucfirst($recette->type) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Véhicule associé</h3>
            @if($recette->vehicule)
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-bold text-white">{{ substr($recette->vehicule?->immatriculation ?? 'VEH', 0, 3) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-lg font-semibold text-gray-900 truncate">{{ $recette->vehicule?->immatriculation ?? 'Non spécifié' }}</h4>
                        <p class="text-sm text-gray-500">{{ $recette->vehicule?->marque ?? '' }} {{ $recette->vehicule?->modele ?? '' }} ({{ $recette->vehicule?->annee ?? 'N/A' }})</p>
                        <p class="text-sm text-gray-600 mt-1">Capacité: {{ $recette->vehicule?->capacite ?? 'N/A' }} places</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-{{ ($recette->vehicule?->statut ?? '') == 'actif' ? 'emerald' : 'gray' }}-100 text-{{ ($recette->vehicule?->statut ?? '') == 'actif' ? 'emerald' : 'gray' }}-800">
                        {{ ucfirst($recette->vehicule?->statut ?? 'inconnu') }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Voyages</span>
                        <div class="font-semibold">{{ $recette->vehicule?->voyages_count ?? 0 }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">Maintenances</span>
                        <div class="font-semibold">{{ $recette->vehicule?->maintenances_count ?? 0 }}</div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg font-semibold mb-2">Aucun véhicule associé</p>
                <p class="text-sm text-gray-400">Ce véhicule n'est pas lié à cette recette.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
            <h3 class="text-xl font-semibold text-gray-800">Activité récente</h3>
        </div>
        <div class="p-6 divide-y divide-gray-100">
            <div class="py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">Recette créée le {{ $recette->created_at?->format('d/m/Y à H:i') }}</p>
                        <p class="text-sm text-gray-500">Montant: {{ number_format($recette->montant, 2) }} €</p>
                    </div>
                </div>
            </div>
            @if($recette->updated_at > $recette->created_at)
            <div class="py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">Dernière modification le {{ $recette->updated_at?->format('d/m/Y à H:i') }}</p>
                        <p class="text-sm text-gray-500">Modifié par le système</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.btn-primary, .btn-secondary {
    @apply inline-flex items-center gap-2 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 font-semibold h-12;
}
.btn-primary {
    @apply bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white;
}
.btn-secondary {
    @apply bg-gray-100 hover:bg-gray-200 text-gray-800;
}
</style>

@endsection
