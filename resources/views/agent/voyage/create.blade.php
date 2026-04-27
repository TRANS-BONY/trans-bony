@extends('layouts.agent')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between animate-slide-down">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Planifier un Voyage</h1>
            <p class="text-sm text-gray-500 mt-1">Créez une nouvelle mission ou maintenance pour la flotte</p>
        </div>
        <a href="{{ route('agent.voyages') }}" class="px-4 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-lg transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl animate-fade-in-up">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-plus-circle text-orange-500"></i> Formulaire de création
            </h2>
        </div>

        <div class="p-6">
            <form action="{{ route('agent.voyages.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date et heure de départ -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt text-orange-500"></i> Date et heure de départ
                        </label>
                        <input type="datetime-local" 
                               name="date_depart" 
                               value="{{ old('date_depart') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                               required>
                        @error('date_depart')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-orange-500"></i> Destination
                        </label>
                        <input type="text" 
                               name="destination" 
                               value="{{ old('destination') }}" 
                               placeholder="Lieu de destination..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                               required>
                        @error('destination')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Véhicule -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-car text-orange-500"></i> Véhicule
                        </label>
                        <select name="vehicule_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                                required>
                            <option value="">Sélectionner un véhicule</option>
                            @foreach($vehicules as $v)
                                <option value="{{ $v->id }}" {{ old('vehicule_id') == $v->id ? 'selected' : '' }}>
                                    {{ $v->immatriculation }} - {{ $v->marque }} {{ $v->modele }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehicule_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chauffeur -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tie text-orange-500"></i> Chauffeur
                        </label>
                        <select name="chauffeur_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                                required>
                            <option value="">Sélectionner un chauffeur</option>
                            @foreach($chauffeurs as $c)
                                <option value="{{ $c->id }}" {{ old('chauffeur_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('chauffeur_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre de passagers -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-users text-orange-500"></i> Nombre de passagers
                        </label>
                        <input type="number" 
                               name="nb_passagers" 
                               value="{{ old('nb_passagers') }}" 
                               min="0" max="52" 
                               placeholder="Ex: 4" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        @error('nb_passagers')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type de voyage -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-orange-500"></i> Type
                        </label>
                        <select name="type" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                                required>
                            <option value="voyage" {{ old('type') == 'voyage' ? 'selected' : '' }}>🚙 Mission</option>
                            <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('agent.voyages') }}" class="px-5 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors shadow-sm">
                        Annuler
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-orange-500 text-white hover:bg-orange-600 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i> Planifier le voyage
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
