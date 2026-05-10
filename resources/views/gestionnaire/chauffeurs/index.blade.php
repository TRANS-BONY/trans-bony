@extends('layouts.gestionnaire')

@section('title', 'Gestion du Personnel')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Chauffeurs</h2>
        <a href="{{ route('gestionnaire.chauffeurs.create') }}" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-teal-500/20">
            <i class="fas fa-plus mr-2"></i> Nouveau chauffeur
        </a>
    </div>
    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($chauffeurs as $c)
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition group">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700 overflow-hidden flex items-center justify-center">
                    @if($c->photo)
                        <img src="{{ asset('storage/' . $c->photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user-tie text-2xl text-gray-400"></i>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $c->nom }} {{ $c->prenom }}</h3>
                    <p class="text-xs text-gray-500">{{ $c->telephone }}</p>
                </div>
            </div>
            
            <div class="space-y-2 mb-6">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 font-medium">Permis:</span>
                    <span class="font-bold">{{ $c->permis }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 font-medium">Statut:</span>
                    <span class="px-2 py-0.5 rounded-full font-bold uppercase {{ $c->actif ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $c->actif ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <div class="flex gap-2 pt-4 border-t border-gray-50 dark:border-gray-700">
                <a href="{{ route('gestionnaire.chauffeurs.show', $c) }}" class="flex-1 py-2 text-center text-xs font-bold bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-teal-50 hover:text-teal-600 transition">Détails</a>
                <a href="{{ route('gestionnaire.chauffeurs.edit', $c) }}" class="p-2 text-blue-600 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 transition"><i class="fas fa-edit"></i></a>
                <form action="{{ route('gestionnaire.chauffeurs.destroy', $c) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="p-2 text-red-600 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 transition"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $chauffeurs->links() }}
    </div>
</div>
@endsection
