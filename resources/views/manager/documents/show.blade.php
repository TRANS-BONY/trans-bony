@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.documents.index') }}" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-500 hover:text-purple-600 rounded-xl shadow-sm border border-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détails du Document #{{ $document->id }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Informations du Document</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Type de Document</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $document->type }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Véhicule</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $document->vehicule->immatriculation ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date d'Expiration</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $document->date_expiration ? $document->date_expiration->format('d/m/Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Référence / Numéro</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $document->numero ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
