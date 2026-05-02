@extends('layouts.gestionnaire')

@section('title', 'Modifier véhicule')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route('gestionnaire.vehicules.update', $vehicule) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Immatriculation</label>
                    <input type="text" name="immatriculation" required value="{{ old('immatriculation', $vehicule->immatriculation) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition uppercase">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Marque</label>
                    <input type="text" name="marque" required value="{{ old('marque', $vehicule->marque) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Modèle</label>
                    <input type="text" name="modele" required value="{{ old('modele', $vehicule->modele) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Année</label>
                    <input type="number" name="annee" required value="{{ old('annee', $vehicule->annee) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Capacité</label>
                    <input type="number" name="capacite" required value="{{ old('capacite', $vehicule->capacite) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Statut</label>
                    <select name="statut" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-teal-500 outline-none transition">
                        <option value="disponible" {{ $vehicule->statut == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="maintenance" {{ $vehicule->statut == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="mission" {{ $vehicule->statut == 'mission' ? 'selected' : '' }}>Mission</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition shadow-lg shadow-teal-500/20">Mettre à jour</button>
                <a href="{{ route('gestionnaire.vehicules.index') }}" class="px-8 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl transition">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
