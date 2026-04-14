@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-600 via-orange-600 to-red-600 p-6 animate-slide-down shadow-xl">
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
                        Modifier la Maintenance
                    </h1>
                    <p class="text-amber-100 text-sm mt-1">Modifiez les informations de l'intervention technique</p>
                </div>
            </div>
            <a href="{{ route('admin.maintenances.index') }}"
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

    <!-- Formulaire de modification -->
    <div class="animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-2xl mx-auto">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-100 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Informations de la maintenance</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Modifiez les détails de l'intervention</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('admin.maintenances.update', $maintenance) }}" class="p-6">
                @csrf
                @method('PUT')

                <!-- Véhicule -->
                <div class="mb-6">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            <circle cx="6" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <circle cx="18" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                        Véhicule <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="vehicule_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 text-gray-900 appearance-none cursor-pointer @error('vehicule_id') border-red-500 @enderror">
                            <option value="" disabled>-- Sélectionnez un véhicule --</option>
                            @foreach($vehicules as $v)
                            <option value="{{ $v->id }}" {{ old('vehicule_id', $maintenance->vehicule_id) == $v->id ? 'selected' : '' }}>
                                {{ $v->immatriculation }} - {{ $v->marque }} {{ $v->modele }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('vehicule_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Véhicule actuel : <span class="font-semibold">{{ $maintenance->vehicule->immatriculation ?? 'N/A' }}</span></p>
                </div>

                <!-- Type de maintenance -->
                <div class="mb-6">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Type de maintenance <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 text-gray-900 appearance-none cursor-pointer @error('type') border-red-500 @enderror">
                            <option value="" disabled>-- Sélectionnez un type --</option>
                            <option value="préventive" {{ old('type', $maintenance->type) == 'préventive' ? 'selected' : '' }}>🛡️ Préventive - Entretien régulier</option>
                            <option value="curative" {{ old('type', $maintenance->type) == 'curative' ? 'selected' : '' }}>🔧 Curative - Réparation après panne</option>
                            <option value="urgente" {{ old('type', $maintenance->type) == 'urgente' ? 'selected' : '' }}>⚠️ Urgente - Intervention immédiate</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('type')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1 text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded">🛡️ Préventive: Vidange, révisions</span>
                        <span class="inline-flex items-center gap-1 text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded">🔧 Curative: Réparation moteur</span>
                        <span class="inline-flex items-center gap-1 text-xs text-red-600 bg-red-50 px-2 py-1 rounded">⚠️ Urgente: Dépannage immédiat</span>
                    </div>
                </div>

                <!-- Date prévue -->
                <div class="mb-6">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Date prévue <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date_prevue"
                           value="{{ old('date_prevue', $maintenance->date_prevue) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 text-gray-900 @error('date_prevue') border-red-500 @enderror">
                    @error('date_prevue')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    @php
                        $datePrevue = \Carbon\Carbon::parse($maintenance->date_prevue);
                        $statusClass = '';
                        $statusText = '';
                        if ($datePrevue->isPast()) {
                            $statusClass = 'text-red-500 bg-red-50';
                            $statusText = '⚠️ Cette maintenance est en retard';
                        } elseif ($datePrevue->diffInDays(now()) <= 7) {
                            $statusClass = 'text-amber-500 bg-amber-50';
                            $statusText = '⏰ Cette maintenance est prévue prochainement';
                        } else {
                            $statusClass = 'text-emerald-500 bg-emerald-50';
                            $statusText = '✅ Cette maintenance est bien planifiée';
                        }
                    @endphp
                    <p class="text-xs {{ $statusClass }} mt-1 p-1 rounded">{{ $statusText }}</p>
                </div>

                <!-- Coût -->
                <div class="mb-8">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Coût (€) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number"
                               step="0.01"
                               name="cout"
                               value="{{ old('cout', $maintenance->cout) }}"
                               placeholder="0.00"
                               min="0"
                               required
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 text-gray-900 @error('cout') border-red-500 @enderror">
                    </div>
                    @error('cout')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Coût total de la maintenance (pièces + main d'œuvre)</p>
                </div>

                <!-- Aperçu de la maintenance -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700">Aperçu de la maintenance</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="text-gray-500">Véhicule:</span>
                            <p class="font-medium text-gray-900">{{ $maintenance->vehicule->immatriculation ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Type actuel:</span>
                            <p class="font-medium text-gray-900 capitalize">{{ $maintenance->type }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Date:</span>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Coût:</span>
                            <p class="font-medium text-green-600">{{ number_format($maintenance->cout, 2) }} €</p>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                            class="group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 flex-1">
                        <div class="relative flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="text-white font-medium">Mettre à jour</span>
                        </div>
                    </button>

                    <a href="{{ route('admin.maintenances.show', $maintenance) }}"
                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-300 hover:scale-105 text-center flex-1">
                        <span class="text-gray-700 font-medium">Annuler</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Conseils supplémentaires -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 animate-fade-in-up max-w-2xl mx-auto" style="animation-delay: 0.2s">
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-4 border border-amber-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-200 rounded-lg">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-amber-600 uppercase tracking-wider">Information</p>
                    <p class="text-sm text-amber-900 font-medium">Tous les champs sont obligatoires</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-sky-50 to-sky-100 rounded-xl p-4 border border-sky-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-sky-200 rounded-lg">
                    <svg class="w-5 h-5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-sky-600 uppercase tracking-wider">Conseil</p>
                    <p class="text-sm text-sky-900 font-medium">Modifiez les dates si nécessaire</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-4 border border-emerald-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-200 rounded-lg">
                    <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-emerald-600 uppercase tracking-wider">Note</p>
                    <p class="text-sm text-emerald-900 font-medium">Le coût peut être mis à jour</p>
                </div>
            </div>
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

    /* Supprimer les flèches des inputs number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 0.5;
    }

    /* Transition douce pour tous les éléments */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endsection
