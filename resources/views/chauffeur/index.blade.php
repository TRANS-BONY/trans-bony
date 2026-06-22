@extends('layouts.chauffeur')

@section('content')
<style> [x-cloak] { display: none !important; } </style>
<div class="space-y-6 animate-fade-in" x-data="{ showIncidentModal: false, selectedVoyageId: null }">
    <!-- Header de Bienvenue -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 to-emerald-600 p-8 shadow-lg">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-3xl font-bold text-white">Bonjour, {{ auth()->user()->name }} ! 👋</h1>
                <p class="text-green-100 mt-2 text-lg">Prêt pour votre prochaine mission ? Sécurité d'abord !</p>
            </div>
            <div class="flex gap-4 items-center">
                <!-- Notifications Bell -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-3 bg-white/20 backdrop-blur-md rounded-xl text-white hover:bg-white/30 transition-all border border-white/20">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 border-2 border-green-600 rounded-full"></span>
                        @endif
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50">
                        <div class="p-4 border-b border-gray-50 dark:border-gray-700 font-bold text-sm text-gray-800 dark:text-white">Notifications</div>
                        <div class="max-h-64 overflow-y-auto custom-scrollbar">
                            @forelse(auth()->user()->notifications->take(5) as $notification)
                                <div class="p-4 border-b border-gray-50 dark:border-gray-700 last:border-0 {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50/30' }}">
                                    <p class="text-[11px] text-gray-800 dark:text-gray-200 leading-tight">{{ $notification->data['message'] }}</p>
                                    <span class="text-[9px] text-gray-400 mt-1 inline-block">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400 text-xs italic">Aucune notification</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white/20 backdrop-blur-md rounded-xl p-4 text-center border border-white/20">
                    <span class="block text-2xl font-bold text-white">{{ count($voyages_chauffeur) }}</span>
                    <span class="text-xs text-green-100 uppercase tracking-wider">Missions</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Mes Prochaines Missions (List) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-route text-green-500"></i> Mes Prochaines Missions
                    </h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($voyages_chauffeur as $v)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <div class="flex gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-green-50 dark:bg-green-900/20 flex flex-col items-center justify-center text-green-600 dark:text-green-400 shrink-0 border border-green-100 dark:border-green-800">
                                    <span class="text-lg font-bold leading-none">{{ $v->date_depart->format('d') }}</span>
                                    <span class="text-[10px] uppercase font-bold">{{ $v->date_depart->translatedFormat('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $v->destination }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">
                                        <i class="far fa-clock mr-1"></i> {{ $v->date_depart->format('H:i') }}
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold border border-blue-100">
                                            <i class="fas fa-bus mr-1"></i> {{ $v->vehicule->immatriculation ?? 'N/A' }}
                                        </span>
                                        @php
                                            $monAffectation = $v->affectations->where('chauffeur_id', auth()->user()->chauffeur->id)->first();
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full bg-{{ $monAffectation && $monAffectation->role_chauffeur == 'principal' ? 'green' : 'amber' }}-50 text-{{ $monAffectation && $monAffectation->role_chauffeur == 'principal' ? 'green' : 'amber' }}-600 text-xs font-semibold border border-{{ $monAffectation && $monAffectation->role_chauffeur == 'principal' ? 'green' : 'amber' }}-100">
                                            Role: {{ $monAffectation && $monAffectation->role_chauffeur == 'principal' ? 'Principal' : 'Relais' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('agent.voyages.manifest', $v->id) }}" target="_blank" class="px-4 py-2 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg text-sm font-bold transition-all flex items-center gap-2 border border-green-100">
                                    <i class="fas fa-file-pdf"></i> Manifeste
                                </a>
                                <button @click="showIncidentModal = true; selectedVoyageId = {{ $v->id }}" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-bold transition-all flex items-center gap-2 border border-red-100">
                                    <i class="fas fa-exclamation-triangle"></i> Signalement
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-500">
                        <i class="fas fa-calendar-check text-4xl mb-4 text-gray-200"></i>
                        <p>Aucune mission prévue pour le moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Signalements -->
        <div class="space-y-6">
            <!-- Rappel Sécurité -->
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-amber-800 font-bold flex items-center gap-2 mb-3">
                    <i class="fas fa-shield-alt"></i> Consignes Sécurité
                </h3>
                <ul class="text-sm text-amber-700 space-y-2">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1 text-xs"></i>
                        Vérifiez la pression des pneus avant le départ.
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1 text-xs"></i>
                        Assurez-vous du bon fonctionnement des feux.
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1 text-xs"></i>
                        Signalez immédiatement toute anomalie.
                    </li>
                </ul>
            </div>

            <!-- Derniers Signalements -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 font-bold text-gray-800 dark:text-white">
                    Mes Signalements Récents
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($mes_signalements as $s)
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-bold uppercase text-{{ $s->gravite == 'critique' ? 'red' : ($s->gravite == 'moyenne' ? 'amber' : 'blue') }}-500">
                                {{ $s->type }}
                            </span>
                            <span class="text-[10px] text-gray-400">{{ $s->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $s->description }}</p>
                        <div class="mt-2 flex justify-between items-center text-xs">
                            <span class="px-2 py-0.5 rounded bg-{{ $s->statut == 'resolu' ? 'green' : 'amber' }}-100 text-{{ $s->statut == 'resolu' ? 'green' : 'orange' }}-700 font-medium capitalize">
                                {{ $s->statut }}
                            </span>
                            @if($s->statut !== 'resolu')
                            <form action="{{ route('chauffeur.signalements.updateStatus', $s->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="statut" value="resolu">
                                <button type="submit" class="text-green-600 hover:underline font-bold">Marquer résolu</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="p-6 text-center text-gray-500 text-sm italic">Aucun signalement.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Signalement -->
    <div x-show="showIncidentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" @click.away="showIncidentModal = false">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Signaler un incident</h3>
                <button @click="showIncidentModal = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('chauffeur.signalements.store') }}" method="POST" class="p-6 space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="voyage_id" :value="selectedVoyageId">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type d'incident</label>
                    <select name="type" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                        <option value="panne">🔧 Panne mécanique</option>
                        <option value="accident">⚠️ Accident</option>
                        <option value="embouteillage">🚗 Embouteillage massif</option>
                        <option value="meteo">⛈️ Météo défavorable</option>
                        <option value="autre">❓ Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gravité</label>
                    <select name="gravite" class="w-full rounded-lg border-gray-300">
                        <option value="faible">🟢 Faible (Information)</option>
                        <option value="moyenne">🟡 Moyenne (Retard prévu)</option>
                        <option value="critique">🔴 Critique (Arrêt immédiat)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300" placeholder="Décrivez l'incident précisément..." required></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="showIncidentModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-bold shadow-lg">Envoyer le Rapport</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
