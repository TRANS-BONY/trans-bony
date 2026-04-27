@extends('layouts.comptable')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-violet-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-2xl shadow-lg backdrop-blur-sm">
                    <i class="fas fa-plus-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Nouveau Rapport</h1>
                    <p class="text-indigo-100 text-sm mt-1">Les données sont pré-calculées sur la période choisie</p>
                </div>
            </div>
            <a href="{{ route('comptable.rapports.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl border border-white/30 backdrop-blur-sm transition hover:scale-105">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 animate-fade-in-up">
        <form method="POST" action="{{ route('comptable.rapports.store') }}" class="p-8 space-y-6" id="rapportForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Titre --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Titre du rapport <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titre" required
                           value="{{ old('titre') }}"
                           placeholder="Ex: Rapport mensuel Avril 2026"
                           class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    @error('titre') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" required id="typeSelect"
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                        <option value="mensuel"      {{ old('type') == 'mensuel'      ? 'selected' : '' }}>Mensuel</option>
                        <option value="trimestriel"  {{ old('type') == 'trimestriel'  ? 'selected' : '' }}>Trimestriel</option>
                        <option value="annuel"       {{ old('type') == 'annuel'       ? 'selected' : '' }}>Annuel</option>
                        <option value="personnalisé" {{ old('type') == 'personnalisé' ? 'selected' : '' }}>Personnalisé</option>
                    </select>
                    @error('type') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Statut --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select name="statut" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                        <option value="brouillon" {{ old('statut', 'brouillon') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                        <option value="publié"    {{ old('statut') == 'publié'    ? 'selected' : '' }}>Publié</option>
                    </select>
                    @error('statut') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Période de début --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Période du <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="periode_debut" required id="periodeDebut"
                           value="{{ old('periode_debut', now()->startOfMonth()->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    @error('periode_debut') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Période de fin --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        au <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="periode_fin" required id="periodeFin"
                           value="{{ old('periode_fin', now()->endOfMonth()->format('Y-m-d')) }}"
                           max="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    @error('periode_fin') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Notes / Observations
                    </label>
                    <textarea name="notes" rows="4"
                              placeholder="Commentaires, observations, recommandations..."
                              class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition resize-none">{{ old('notes') }}</textarea>
                    @error('notes') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Aperçu données calculées --}}
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-info-circle text-indigo-500"></i>
                    <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">Données calculées automatiquement à la création</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                    <div class="p-2 bg-white dark:bg-gray-700 rounded-lg">
                        <p class="text-xs text-gray-400">Recettes</p>
                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">Auto</p>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-700 rounded-lg">
                        <p class="text-xs text-gray-400">Voyages</p>
                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">Auto</p>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-700 rounded-lg">
                        <p class="text-xs text-gray-400">Véhicules</p>
                        <p class="text-sm font-bold text-violet-600 dark:text-violet-400">Auto</p>
                    </div>
                    <div class="p-2 bg-white dark:bg-gray-700 rounded-lg">
                        <p class="text-xs text-gray-400">Chauffeurs</p>
                        <p class="text-sm font-bold text-amber-600 dark:text-amber-400">Auto</p>
                    </div>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-save"></i> Créer le rapport
                </button>
                <a href="{{ route('comptable.rapports.index') }}"
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

<script>
// Pré-remplir les dates automatiquement selon le type sélectionné
document.getElementById('typeSelect')?.addEventListener('change', function () {
    const type   = this.value;
    const debut  = document.getElementById('periodeDebut');
    const fin    = document.getElementById('periodeFin');
    const now    = new Date();
    const y      = now.getFullYear();
    const m      = now.getMonth();

    if (type === 'mensuel') {
        debut.value = new Date(y, m, 1).toISOString().split('T')[0];
        fin.value   = new Date(y, m + 1, 0).toISOString().split('T')[0];
    } else if (type === 'trimestriel') {
        const q = Math.floor(m / 3);
        debut.value = new Date(y, q * 3, 1).toISOString().split('T')[0];
        fin.value   = new Date(y, q * 3 + 3, 0).toISOString().split('T')[0];
    } else if (type === 'annuel') {
        debut.value = new Date(y, 0, 1).toISOString().split('T')[0];
        fin.value   = new Date(y, 11, 31).toISOString().split('T')[0];
    }
});
</script>
@endsection
