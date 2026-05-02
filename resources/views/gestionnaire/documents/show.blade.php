@extends('layouts.gestionnaire')

@section('title', 'Détails Document')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('gestionnaire.documents.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-teal-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $document->type }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="p-6 bg-teal-50 dark:bg-teal-900/20 rounded-2xl">
                    <p class="text-[10px] text-teal-600 font-bold uppercase mb-1">Véhicule associé</p>
                    <p class="text-lg font-bold">{{ $document->vehicule->immatriculation ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500">{{ $document->vehicule->marque ?? '' }} {{ $document->vehicule->modele ?? '' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">Date émission</p>
                        <p class="text-sm font-bold">{{ \Carbon\Carbon::parse($document->date_emission)->format('d/m/Y') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">Date expiration</p>
                        <p class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($document->date_expiration)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl p-8">
                <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                <p class="text-sm font-bold mb-4">Document Numérisé</p>
                <a href="{{ asset('storage/' . $document->fichier) }}" target="_blank" class="px-6 py-2 bg-teal-600 text-white text-xs font-bold rounded-xl hover:bg-teal-700 transition">
                    Visualiser le fichier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
