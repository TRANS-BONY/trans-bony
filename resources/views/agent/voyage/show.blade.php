@extends('layouts.agent')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between animate-slide-down">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Détails du Voyage</h1>
            <p class="text-sm text-gray-500 mt-1">Consultez les informations complètes de ce voyage</p>
        </div>
        <a href="{{ route('agent.voyages') }}" class="px-4 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-lg transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center gap-3">
            <div class="p-2 bg-white/20 rounded-lg">
                <i class="fas fa-route text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">
                    {{ $voyage->destination }}
                </h2>
                <p class="text-blue-100 text-sm">
                    Planifié pour le {{ \Carbon\Carbon::parse($voyage->date_depart)->isoFormat('DD MMM YYYY à HH:mm') }}
                </p>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Info Voyage --}}
                <div class="space-y-6">
                    <h3 class="text-sm uppercase tracking-widest text-gray-400 font-bold border-b border-gray-100 pb-2">Informations Générales</h3>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Destination</p>
                            <p class="text-gray-800 font-medium mt-0.5">{{ $voyage->destination }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-alt text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Date et Heure</p>
                            <p class="text-gray-800 font-medium mt-0.5">{{ \Carbon\Carbon::parse($voyage->date_depart)->isoFormat('dddd DD MMMM YYYY, HH:mm') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Passagers</p>
                            <p class="text-gray-800 font-medium mt-0.5">
                                {{ $voyage->nb_passagers ?? 0 }} passager(s)
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tag text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Type Renseigné</p>
                            <p class="mt-1">
                                @if($voyage->type == 'maintenance')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-amber-50 text-amber-600 border border-amber-200">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Maintenance
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-600 border border-blue-200">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Mission
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Détails Assignation --}}
                <div class="space-y-6">
                    <h3 class="text-sm uppercase tracking-widest text-gray-400 font-bold border-b border-gray-100 pb-2">Assignations</h3>
                    
                    <div class="p-5 rounded-xl border border-gray-100 bg-gray-50">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-white shadow-sm rounded-lg">
                                <i class="fas fa-car text-gray-400 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Véhicule Assigné</h4>
                                @if($voyage->vehicule)
                                    <p class="font-bold text-gray-800 text-lg">{{ $voyage->vehicule->immatriculation }}</p>
                                    <p class="text-sm border-l-2 border-orange-400 pl-2 text-gray-600 mt-1">{{ $voyage->vehicule->marque }} {{ $voyage->vehicule->modele }}</p>
                                @else
                                    <p class="text-red-500 text-sm font-medium italic mt-1">Non assigné</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-xl border border-gray-100 bg-gray-50">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="p-3 bg-white shadow-sm rounded-lg">
                                <i class="fas fa-user-tie text-gray-400 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Chauffeur Assigné</h4>
                                @if($voyage->chauffeur)
                                    <p class="font-bold text-gray-800 text-lg">{{ $voyage->chauffeur->nom }}</p>
                                    <p class="text-sm border-l-2 border-green-400 pl-2 text-gray-600 mt-1">
                                        {{ $voyage->chauffeur->telephone ?? 'Téléphone non précisé' }}
                                    </p>
                                @else
                                    <p class="text-red-500 text-sm font-medium italic mt-1">Non assigné</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('agent.voyages.edit', $voyage->id) }}" class="px-5 py-2.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-800 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('agent.voyages.destroy', $voyage->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce voyage ?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white hover:bg-red-700 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
