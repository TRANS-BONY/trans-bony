@extends('layouts.app')

@section('content')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<div class="space-y-6">
    <!-- Header avec dégradé plein -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 p-6 animate-slide-down shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl shadow-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12h.01M12 16h.01" stroke="currentColor"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Planning des Voyages
                    </h1>
                    <p class="text-orange-100 text-sm mt-1">Gérez et planifiez vos missions et maintenances</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs text-white">En direct</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- 📅 CALENDRIER -->
        <div class="lg:w-3/4 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Calendrier des événements</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Cliquez sur un événement pour le supprimer - Glissez pour déplacer</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div id='calendar' class="fullcalendar-custom"></div>
                </div>
            </div>
        </div>

        <!-- ➕ FORMULAIRE D'AJOUT -->
        <div class="lg:w-1/4 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-6">
                <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Nouveau Voyage</h3>
                            <p class="text-orange-100 text-xs">Planifiez une mission ou maintenance</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg animate-fade-in-up">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-emerald-700">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-red-700">Erreurs de validation</span>
                            </div>
                            @foreach($errors->all() as $error)
                                <p class="text-xs text-red-600 ml-7">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

<form method="POST" action="{{ route('admin.voyages.store') }}" class="space-y-4">
                        @csrf

                        <!-- Date et heure de départ -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Date et heure de départ
                            </label>
                            <input type="datetime-local"
                                   name="date_depart"
                                   value="{{ old('date_depart') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                   required>
                        </div>

                        <!-- Destination -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Destination
                            </label>
                            <input type="text"
                                   name="destination"
                                   value="{{ old('destination') }}"
                                   placeholder="Ex: Douala, Yaoundé, Garoua..."
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                   required>
                        </div>

                        <!-- Véhicule -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                Véhicule
                            </label>
                            <select name="vehicule_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                    required>
                                <option value="">-- Sélectionnez un véhicule --</option>
                                @foreach($vehicules as $v)
                                    <option value="{{ $v->id }}" {{ old('vehicule_id') == $v->id ? 'selected' : '' }}>
                                        {{ $v->immatriculation }} - {{ $v->marque }} {{ $v->modele }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Chauffeur -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Chauffeur
                            </label>
                            <select name="chauffeur_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                    required>
                                <option value="">-- Sélectionnez un chauffeur --</option>
                                @foreach($chauffeurs as $c)
                                    <option value="{{ $c->id }}" {{ old('chauffeur_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type de voyage -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                Type
                            </label>
                            <div class="relative">
                                <select name="type"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 appearance-none cursor-pointer"
                                        required>
                                    <option value="voyage" {{ old('type') == 'voyage' ? 'selected' : '' }}>🚗 Mission</option>
                                    <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Nombre de passagers -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Nombre de passagers
                            </label>
                            <input type="number"
                                   name="nb_passagers"
                                   value="{{ old('nb_passagers') }}"
                                   min="0"
                                   max="52"
                                   placeholder="Ex: 4"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                        </div>

                        <!-- Bouton d'envoi -->
                        <button type="submit"
                                class="w-full group relative overflow-hidden bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 rounded-lg py-3 transition-all duration-300 hover:scale-105 shadow-lg">
                            <div class="relative flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-white font-medium">Planifier le voyage</span>
                            </div>
                        </button>
                    </form>
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

    /* Styles personnalisés pour FullCalendar */
    .fullcalendar-custom {
        font-family: inherit;
    }

    .fc {
        background: white;
        border-radius: 0.5rem;
    }

    .fc .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }

    .fc .fc-button-primary {
        background-color: #f97316;
        border-color: #f97316;
        transition: all 0.3s ease;
    }

    .fc .fc-button-primary:hover {
        background-color: #ea580c;
        border-color: #ea580c;
        transform: scale(1.05);
    }

    .fc .fc-button-primary:not(:disabled):active {
        background-color: #ea580c;
        border-color: #ea580c;
    }

    .fc .fc-daygrid-day {
        transition: background-color 0.2s ease;
    }

    .fc .fc-daygrid-day:hover {
        background-color: #fff7ed;
    }

    .fc-event {
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        padding: 2px 4px;
        font-size: 0.8rem;
    }

    .fc-event:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Couleurs personnalisées pour les événements */
    .fc-event.voyage-event {
        background-color: #3b82f6;
        border-left: 3px solid #1e40af;
    }

    .fc-event.maintenance-event {
        background-color: #f59e0b;
        border-left: 3px solid #b45309;
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

    /* Scrollbar personnalisée */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #f97316;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #ea580c;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour'
        },
events: "{{ route('admin.voyages.events') }}",
        eventDidMount: function(info) {
            // Ajouter une classe CSS selon le type d'événement
            if (info.event.extendedProps.type === 'maintenance') {
                info.el.classList.add('maintenance-event');
            } else {
                info.el.classList.add('voyage-event');
            }

            // Ajouter un tooltip
            info.el.setAttribute('title', `${info.event.title}\nDépart: ${info.event.start.toLocaleString()}`);
        },
        eventDrop: function(info) {
            fetch('/admin/voyages/' + info.event.id + '/move', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    date: info.event.start.toISOString()
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.error){
                    alert(data.error);
                    info.revert();
                } else {
                    // Afficher une notification de succès
                    showNotification('Événement déplacé avec succès', 'success');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                info.revert();
                showNotification('Erreur lors du déplacement', 'error');
            });
        },
        eventClick: function(info){
            if(confirm("⚠️ Supprimer ce voyage ?\n\n" + info.event.title + "\n\nCette action est irréversible.")){
                fetch('/admin/voyages/' + info.event.id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        info.event.remove();
                        showNotification('Événement supprimé avec succès', 'success');
                    } else {
                        showNotification('Erreur lors de la suppression', 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la suppression', 'error');
                });
            }
        },
        locale: 'fr',
        firstDay: 1, // Lundi comme premier jour de la semaine
        height: 'auto',
        contentHeight: 'auto'
    });

    calendar.render();

    // Fonction pour afficher des notifications
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg animate-fade-in-up ${
            type === 'success' ? 'bg-emerald-500' : 'bg-red-500'
        } text-white`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'success'
                            ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                            : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    }"></path>
                </svg>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>

@endsection
