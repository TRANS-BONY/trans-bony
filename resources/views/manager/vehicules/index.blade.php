@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Parc Automobile</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultation globale des véhicules</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @forelse($vehicules as $v)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-bus"></i>
                </div>
                <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700">
                    {{ ucfirst($v->statut) }}
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $v->marque }} {{ $v->modele }}</h3>
            <p class="text-sm font-mono text-gray-500 mb-4">{{ $v->immatriculation }}</p>
            <a href="{{ route('manager.vehicules.show', $v) }}" class="block text-center py-2 bg-gray-50 hover:bg-gray-100 text-sm font-semibold text-gray-700 rounded-lg transition">
                Détails
            </a>
        </div>
        @empty
        <div class="col-span-full p-8 text-center text-gray-500">Aucun véhicule enregistré.</div>
        @endforelse
    </div>
    
    @if($vehicules->hasPages())
    <div class="mt-4">{{ $vehicules->links() }}</div>
    @endif
</div>
@endsection
