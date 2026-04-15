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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Détails de la Maintenance
                    </h1>
                    <p class="text-amber-100 text-sm mt-1">Informations complètes de l'intervention technique</p>
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

    <!-- Détails de la maintenance -->
    <div class="animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-3xl mx-auto">
            <!-- En-tête du détail -->
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-100 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Fiche d'intervention</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Maintenance #{{ $maintenance->id }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Carte de statut -->
                @php
                    $datePrevue = \Carbon\Carbon::parse($maintenance->date_prevue);
                    $statusClass = '';
                    $statusIcon = '';
                    $statusText = '';
                    if ($datePrevue->isPast()) {
                        $statusClass = 'bg-red-50 border-red-200';
                        $statusIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                        $statusText = 'En retard';
                    } elseif ($datePrevue->diffInDays(now()) <= 7) {
                        $statusClass = 'bg-amber-50 border-amber-200';
                        $statusIcon = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                        $statusText = 'Proche échéance';
                    } else {
                        $statusClass = 'bg-emerald-50 border-emerald-200';
                        $statusIcon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                        $statusText = 'Bien planifiée';
                    }
                @endphp

                <div class="mb-8 p-4 rounded-lg border {{ $statusClass }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 {{ str_contains($statusClass, 'red') ? 'text-red-500' : (str_contains($statusClass, 'amber') ? 'text-amber-500' : 'text-emerald-500') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcon }}"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold {{ str_contains($statusClass, 'red') ? 'text-red-700' : (str_contains($statusClass, 'amber') ? 'text-amber-700' : 'text-emerald-700') }}">
                                {{ $statusText }}
                            </p>
                            @if($datePrevue->isPast())
                                <p class="text-xs text-red-600">Cette maintenance aurait dû être effectuée le {{ $datePrevue->format('d/m/Y') }}</p>
                            @elseif($datePrevue->diffInDays(now()) <= 7)
                                <p class="text-xs text-amber-600">Plus que {{ $datePrevue->diffInDays(now()) }} jour(s) avant la date prévue</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Véhicule -->
                    <div class="group hover:bg-gray-50 p-4 rounded-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    <circle cx="6" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <circle cx="18" cy="18" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Véhicule concerné</label>
                                <p class="text-xl font-bold text-gray-900">{{ $maintenance->vehicule?->immatriculation ?? 'N/A' }}</p>
                                @if($maintenance->vehicule)
                                    <div class="flex gap-3 mt-1 text-sm text-gray-500">
                                        <span>{{ $maintenance->vehicule?->marque ?? '' }} {{ $maintenance->vehicule?->modele ?? '' }}</span>
                                        <span>•</span>
                                        <span>{{ $maintenance->vehicule?->annee ?? '' }}</span>
                                        <span>•</span>
                                        <span>{{ $maintenance->vehicule?->capacite ?? '' }} places</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Type de maintenance -->
                    <div class="group hover:bg-gray-50 p-4 rounded-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Type de maintenance</label>
                                @php
                                    $typeConfig = [
                                        'préventive' => ['color' => 'text-blue-600', 'bg' => 'bg-blue-100', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Préventive'],
                                        'curative' => ['color' => 'text-amber-600', 'bg' => 'bg-amber-100', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'label' => 'Curative'],
                                        'urgente' => ['color' => 'text-red-600', 'bg' => 'bg-red-100', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Urgente']
                                    ];
                                    $config = $typeConfig[$maintenance->type] ?? $typeConfig['préventive'];
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['color'] }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                        </svg>
                                        {{ $config['label'] }}
                                    </span>
                                    <span class="text-sm text-gray-500 capitalize">{{ $maintenance->type }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date prévue -->
                    <div class="group hover:bg-gray-50 p-4 rounded-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date prévue</label>
                                <p class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($maintenance->date_prevue)->diffForHumans() }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Coût -->
                    <div class="group hover:bg-gray-50 p-4 rounded-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Coût total</label>
                                <p class="text-3xl font-bold text-emerald-600">{{ number_format($maintenance->cout, 2) }} FCFA</p>
                                <p class="text-sm text-gray-500 mt-1">TTC - Pièces et main d'œuvre incluses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.maintenances.edit', $maintenance) }}"
                           class="group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 flex-1 text-center">
                            <div class="relative flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="text-white font-medium">Modifier la maintenance</span>
                            </div>
                        </a>

                        <form method="POST" action="{{ route('admin.maintenances.destroy', $maintenance) }}" class="inline flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette maintenance ?\n\nVéhicule : {{ $maintenance->vehicule?->immatriculation ?? 'N/A' }}\nType : {{ $maintenance->type }}\nDate : {{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}\nCoût : {{ number_format($maintenance->cout, 2) }} FCFA\n\nCette action est irréversible.')"
                                    class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-lg shadow-lg transition-all duration-300 hover:scale-105">
                                <div class="relative flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span class="text-white font-medium">Supprimer</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conseils supplémentaires -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 animate-fade-in-up max-w-3xl mx-auto" style="animation-delay: 0.2s">
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-4 border border-amber-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-200 rounded-lg">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-amber-600 uppercase tracking-wider">Conseil</p>
                    <p class="text-sm text-amber-900 font-medium">Effectuez les maintenances préventives régulièrement</p>
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
                    <p class="text-xs text-sky-600 uppercase tracking-wider">Information</p>
                    <p class="text-sm text-sky-900 font-medium">Gardez un historique des interventions</p>
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
                    <p class="text-sm text-emerald-900 font-medium">Suivez l'évolution des coûts par véhicule</p>
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

    /* Transition douce pour tous les éléments */
    * {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endsection
