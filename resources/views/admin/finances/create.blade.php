@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-plus-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Nouvelle Recette</h1>
                    <p class="text-emerald-100 text-sm mt-1">Enregistrez un nouveau revenu mensuel</p>
                </div>
            </div>
            <a href="{{ route('admin.recettes.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl border border-white/30 backdrop-blur-sm transition hover:scale-105">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 animate-fade-in-up">
        <form method="POST" action="{{ route('admin.recettes.store') }}" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Voyage --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Voyage Lié <span class="text-red-500">*</span>
                    </label>
                    <select name="voyage_id" id="voyage_select" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        <option value="">Sélectionner un voyage...</option>
                        @foreach($voyages as $voyage)
                            <option value="{{ $voyage->id }}" 
                                    data-vehicule-id="{{ $voyage->vehicule_id }}"
                                    {{ old('voyage_id') == $voyage->id ? 'selected' : '' }}>
                                {{ $voyage->destination }} ({{ $voyage->date_depart->format('d/m/Y') }}) - {{ $voyage->vehicule->immatriculation }}
                            </option>
                        @endforeach
                    </select>
                    @error('voyage_id') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Véhicule --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Véhicule (Déduit du voyage) <span class="text-red-500">*</span>
                    </label>
                    <select name="vehicule_id" id="vehicule_select" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition cursor-not-allowed">
                        <option value="">Sélectionner un véhicule...</option>
                        @foreach($vehicules as $vehicule)
                            <option value="{{ $vehicule->id }}" {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                {{ $vehicule->immatriculation ?? 'VEH-'.$vehicule->id }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicule_id') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const voyageSelect = document.getElementById('voyage_select');
    const vehiculeSelect = document.getElementById('vehicule_select');

    voyageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const vehiculeId = selectedOption.getAttribute('data-vehicule-id');
        if (vehiculeId) {
            vehiculeSelect.value = vehiculeId;
        }
    });

    if (voyageSelect.value) {
        voyageSelect.dispatchEvent(new Event('change'));
    }
});
</script>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Type de recette <span class="text-red-500">*</span>
                    </label>
                    <select name="type" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        <option value="">Sélectionner un type...</option>
                        <option value="Billet"   {{ old('type') == 'Billet'   ? 'selected' : '' }}>Billet</option>
                        <option value="Location" {{ old('type') == 'Location' ? 'selected' : '' }}>Location</option>
                        <option value="Fret"     {{ old('type') == 'Fret'     ? 'selected' : '' }}>Fret</option>
                        <option value="Autre"    {{ old('type') == 'Autre'    ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('type') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Montant --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Montant (FCFA) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">CFA</span>
                        <input type="number" name="montant" step="1" min="7500" required
                               value="{{ old('montant') }}"
                               class="w-full pl-14 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"
                               placeholder="Minimum 7500">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimum 7 500 FCFA, pas de nombres décimaux.</p>
                    @error('montant') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" required
                           value="{{ old('date', now()->format('Y-m-d')) }}"
                           max="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    @error('date') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Boutons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-save"></i> Enregistrer la recette
                </button>
                <a href="{{ route('admin.recettes.index') }}"
                   class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInUp  { from { opacity: 0; transform: translateY(20px);  } to { opacity: 1; transform: translateY(0); } }
.animate-slide-down  { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-fade-in-up  { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s forwards; }
</style>
@endsection

