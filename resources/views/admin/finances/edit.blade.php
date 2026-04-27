@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-edit text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Modifier la Recette</h1>
                    <p class="text-indigo-100 text-sm mt-1">
                        {{ \Carbon\Carbon::parse($recette->mois ?? $recette->date)->isoFormat('MMMM YYYY') }}
                        — {{ number_format($recette->montant, 0, ',', ' ') }} FCFA
                    </p>
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
        <form method="POST" action="{{ route('admin.recettes.update', $recette) }}" class="p-8 space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Véhicule --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Véhicule <span class="text-red-500">*</span>
                    </label>
                    <select name="vehicule_id" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                        <option value="">Sélectionner un véhicule...</option>
                        @foreach($vehicules as $vehicule)
                            <option value="{{ $vehicule->id }}" {{ old('vehicule_id', $recette->vehicule_id) == $vehicule->id ? 'selected' : '' }}>
                                {{ $vehicule->immatriculation ?? 'VEH-'.$vehicule->id }}
                                {{ $vehicule->marque ?? '' }} {{ $vehicule->modele ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicule_id') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Type de recette <span class="text-red-500">*</span>
                    </label>
                    <select name="type" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                        <option value="">Sélectionner un type...</option>
                        <option value="Billet"   {{ old('type', $recette->type) == 'Billet'   ? 'selected' : '' }}>Billet</option>
                        <option value="Location" {{ old('type', $recette->type) == 'Location' ? 'selected' : '' }}>Location</option>
                        <option value="Fret"     {{ old('type', $recette->type) == 'Fret'     ? 'selected' : '' }}>Fret</option>
                        <option value="Autre"    {{ old('type', $recette->type) == 'Autre'    ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('type') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Montant --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Montant (FCFA) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold text-sm">XOF</span>
                        <input type="number" name="montant" step="0.01" min="0" required
                               value="{{ old('montant', $recette->montant) }}"
                               class="w-full pl-14 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    @error('montant') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" required
                           value="{{ old('date', \Carbon\Carbon::parse($recette->date ?? $recette->mois)->format('Y-m-d')) }}"
                           max="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    @error('date') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Boutons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('admin.recettes.show', $recette) }}"
                   class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-eye"></i> Voir le détail
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

