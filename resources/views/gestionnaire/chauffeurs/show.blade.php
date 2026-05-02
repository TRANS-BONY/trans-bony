@extends('layouts.gestionnaire')

@section('title', 'Détails Chauffeur')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('gestionnaire.chauffeurs.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-teal-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $chauffeur->nom }} {{ $chauffeur->prenom }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col items-center md:items-start gap-6">
                <div class="w-40 h-40 rounded-3xl bg-gray-100 dark:bg-gray-700 overflow-hidden shadow-inner flex items-center justify-center">
                    @if($chauffeur->photo)
                        <img src="{{ asset('storage/' . $chauffeur->photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user-tie text-5xl text-gray-400"></i>
                    @endif
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $chauffeur->actif ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $chauffeur->actif ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">N° Permis</p>
                        <p class="text-sm font-bold">{{ $chauffeur->permis }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">Téléphone</p>
                        <p class="text-sm font-bold">{{ $chauffeur->telephone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
                
                <div class="p-6 border border-gray-100 dark:border-gray-700 rounded-2xl space-y-4">
                    <h3 class="text-sm font-bold border-b pb-2 mb-4">Informations Système</h3>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Date d'enregistrement</span>
                        <span class="font-medium">{{ $chauffeur->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
