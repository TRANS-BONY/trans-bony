@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Nouvelle Recette Mensuelle</h1>
                    <p class="text-emerald-100">Enregistrez les revenus de votre flotte</p>
                </div>
            </div>
            <a href="{{ route('admin.recettes.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 backdrop-blur-sm border border-white/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
        <form method="POST" action="{{ route('admin.recettes.store') }}" class="p-8 space-y-8">
            @csrf

            <!-- Véhicule -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicule_id" required class="w-full p-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-inner transition-all duration-300 text-lg h-14 hover:border-emerald-400">
                    <option value="">Sélectionner un véhicule...</option>
                    @foreach($vehicules as $vehicule)
                        <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                            {{ $vehicule->immatriculation ?? 'VEH-' . $vehicule->id }} - {{ Str::limit($vehicule->marque ?? '', 30) }} {{ $vehicule->modele ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('vehicule_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Montant & Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Montant (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="montant" step="0.01" min="0" required
                           value="{{ old('montant') }}"
                           class="w-full p-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-inner transition-all duration-300 text-lg h-14 hover:border-emerald-400" placeholder="0.00">
                    @error('montant') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" required
                           value="{{ old('date') }}"
                           class="w-full p-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-inner transition-all duration-300 text-lg h-14 hover:border-emerald-400" max="{{ now()->format('Y-m-d') }}">
                    @error('date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Type <span class="text-red-500">*</span></label>
                <select name="type" required class="w-full p-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-inner transition-all duration-300 text-lg h-14 hover:border-emerald-400">
                    <option value="">Sélectionner un type...</option>
                    <option value="Billet" {{ old('type') == 'Billet' ? 'selected' : '' }}>Billet</option>
                    <option value="Location" {{ old('type') == 'Location' ? 'selected' : '' }}>Location</option>
                    <option value="Fret" {{ old('type') == 'Fret' ? 'selected' : '' }}>Fret</option>
                    <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('type') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 h-14 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Enregistrer la recette
                </button>
                <a href="{{ route('admin.recettes.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 h-14 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s forwards; }
</style>

@endsection

