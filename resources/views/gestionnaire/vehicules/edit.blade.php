@extends('layouts.gestionnaire')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-600 via-emerald-600 to-cyan-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Modifier le Véhicule
                    </h1>
                    <p class="text-emerald-100 text-sm mt-1">Édition de : {{ $vehicule->immatriculation }} • Gestionnaire</p>
                </div>
            </div>
            <a href="{{ route('gestionnaire.vehicules.index') }}"
               class="group px-6 py-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm">
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="text-white font-medium">Retour à la liste</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Formulaire d'édition -->
    <div class="animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-transparent dark:border-gray-700">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-teal-100 dark:bg-teal-900/50 rounded-lg">
                        <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Informations du véhicule</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Mettez à jour les détails ci-dessous</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('gestionnaire.vehicules.update', $vehicule) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Immatriculation -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Immatriculation <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="immatriculation"
                               id="immatriculation"
                               value="{{ old('immatriculation', $vehicule->immatriculation) }}"
                               placeholder="EX: 123 AB 4"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('immatriculation') border-red-500 @enderror"
                               pattern="\d{3,4} [A-Z]{2} \d{1}"
                               maxlength="10"
                               required>
                        @error('immatriculation')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: 123 AB 4 ou 1234 AB 4 (3-4 chiffres, 2 lettres, 1 chiffre)</p>
                    </div>

                    <!-- Marque -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Marque <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="marque"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 dark:text-white appearance-none cursor-pointer @error('marque') border-red-500 @enderror"
                                    required>
                                <option value="" disabled>-- Sélectionnez une marque --</option>
                                <option value="TOYOTA" {{ old('marque', $vehicule->marque) == 'TOYOTA' ? 'selected' : '' }}>Toyota</option>
                                <option value="RENAULT" {{ old('marque', $vehicule->marque) == 'RENAULT' ? 'selected' : '' }}>Renault</option>
                                <option value="PEUGEOT" {{ old('marque', $vehicule->marque) == 'PEUGEOT' ? 'selected' : '' }}>Peugeot</option>
                                <option value="MERCEDES" {{ old('marque', $vehicule->marque) == 'MERCEDES' ? 'selected' : '' }}>Mercedes</option>
                                <option value="FORD" {{ old('marque', $vehicule->marque) == 'FORD' ? 'selected' : '' }}>Ford</option>
                                <option value="HYUNDAI" {{ old('marque', $vehicule->marque) == 'HYUNDAI' ? 'selected' : '' }}>Hyundai</option>
                                <option value="MITSUBISHI" {{ old('marque', $vehicule->marque) == 'MITSUBISHI' ? 'selected' : '' }}>Mitsubishi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('marque')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modèle -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Modèle <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="modele"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 dark:text-white appearance-none cursor-pointer @error('modele') border-red-500 @enderror"
                                    required>
                                <option value="" disabled>-- Sélectionnez un modèle --</option>
                                <option value="YARIS" {{ old('modele', $vehicule->modele) == 'YARIS' ? 'selected' : '' }}>Yaris</option>
                                <option value="COROLLA" {{ old('modele', $vehicule->modele) == 'COROLLA' ? 'selected' : '' }}>Corolla</option>
                                <option value="CLIO" {{ old('modele', $vehicule->modele) == 'CLIO' ? 'selected' : '' }}>Clio</option>
                                <option value="208" {{ old('modele', $vehicule->modele) == '208' ? 'selected' : '' }}>208</option>
                                <option value="308" {{ old('modele', $vehicule->modele) == '308' ? 'selected' : '' }}>308</option>
                                <option value="CLASSE A" {{ old('modele', $vehicule->modele) == 'CLASSE A' ? 'selected' : '' }}>Classe A</option>
                                <option value="SPRINTER" {{ old('modele', $vehicule->modele) == 'SPRINTER' ? 'selected' : '' }}>Sprinter</option>
                                <option value="TRANSIT" {{ old('modele', $vehicule->modele) == 'TRANSIT' ? 'selected' : '' }}>Transit</option>
                                <option value="HIACE" {{ old('modele', $vehicule->modele) == 'HIACE' ? 'selected' : '' }}>Hiace</option>
                                <option value="COASTER" {{ old('modele', $vehicule->modele) == 'COASTER' ? 'selected' : '' }}>Coaster</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('modele')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Année -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Année <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="annee"
                               value="{{ old('annee', $vehicule->annee) }}"
                               min="1950"
                               max="2026"
                               placeholder="Ex: 2020"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('annee') border-red-500 @enderror"
                               required>
                        @error('annee')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacité -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Capacité <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="capacite"
                               value="{{ old('capacite', $vehicule->capacite) }}"
                               min="1"
                               max="52"
                               placeholder="Nombre de places (Ex: 5)"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 @error('capacite') border-red-500 @enderror"
                               required>
                        @error('capacite')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="statut"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 dark:text-white appearance-none cursor-pointer @error('statut') border-red-500 @enderror"
                                    required>
                                <option value="disponible" {{ old('statut', $vehicule->statut) == 'disponible' ? 'selected' : '' }} class="text-emerald-600 dark:text-emerald-400">🟢 Disponible</option>
                                <option value="mission" {{ old('statut', $vehicule->statut) == 'mission' ? 'selected' : '' }} class="text-sky-600 dark:text-sky-400">🔵 En mission</option>
                                <option value="maintenance" {{ old('statut', $vehicule->statut) == 'maintenance' ? 'selected' : '' }} class="text-amber-600 dark:text-amber-400">🟠 Maintenance</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('statut')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                            class="group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 flex-1">
                        <div class="relative flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-white font-medium">Mettre à jour le véhicule</span>
                        </div>
                    </button>

                    <a href="{{ route('gestionnaire.vehicules.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-all duration-300 hover:scale-105 text-center flex-1">
                        <span class="text-gray-700 dark:text-gray-200 font-medium">Annuler</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-down {
        animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Style pour les champs de formulaire */
    input:focus, select:focus {
        outline: none;
    }

    /* Transition douce pour tous les éléments */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const immatInput = document.getElementById('immatriculation');
    if (immatInput) {
        immatInput.addEventListener('input', function(e) {
            let cursorPosition = e.target.selectionStart;
            let value = e.target.value.toUpperCase();
            let cleanValue = value.replace(/[^A-Z0-9]/g, '');
            let formatted = '';

            if (cleanValue.length > 0) {
                // 1. Chiffres (3 ou 4)
                let digitsMatch = cleanValue.match(/^\d+/);
                if (digitsMatch) {
                    let digits = digitsMatch[0].substring(0, 4);
                    formatted = digits;
                    
                    let rest = cleanValue.substring(digits.length);
                    if (rest.length > 0) {
                        if (digits.length === 4 || (digits.length === 3 && rest[0].match(/[A-Z]/))) {
                            formatted += ' ';
                            let lettersMatch = rest.match(/[A-Z]+/);
                            if (lettersMatch) {
                                let letters = lettersMatch[0].substring(0, 2);
                                formatted += letters;
                                let restAfterLetters = rest.substring(letters.length);
                                if (restAfterLetters.length > 0) {
                                    let lastDigitMatch = restAfterLetters.match(/\d/);
                                    if (lastDigitMatch) {
                                        formatted += ' ' + lastDigitMatch[0];
                                    }
                                }
                            }
                        } else if (digits.length === 3 && rest.length > 0 && rest[0].match(/\d/)) {
                            formatted = digits + rest[0];
                            let restAfter4 = rest.substring(1);
                            if (restAfter4.length > 0 && restAfter4[0].match(/[A-Z]/)) {
                                formatted += ' ';
                                let lettersMatch = restAfter4.match(/[A-Z]+/);
                                if (lettersMatch) {
                                    let letters = lettersMatch[0].substring(0, 2);
                                    formatted += letters;
                                    let lastPart = restAfter4.substring(letters.length);
                                    if (lastPart.length > 0) {
                                        let lastDigit = lastPart.match(/\d/);
                                        if (lastDigit) formatted += ' ' + lastDigit[0];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            e.target.value = formatted;
        });
    }
});
</script>
@endpush
@endsection
