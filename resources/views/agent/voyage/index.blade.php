@extends('layouts.agent')

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
                <a href="{{ route('agent.voyages.create') }}" class="px-4 py-2 bg-white text-orange-600 font-medium rounded-lg hover:bg-orange-50 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fas fa-plus"></i> Nouveau voyage
                </a>
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
        <div class="w-full animate-fade-in-up" style="animation-delay: 0.1s">
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

        <!-- 📋 LISTE DETAILLEE DES VOYAGES -->
    <div class="mt-8 animate-fade-in-up" style="animation-delay: 0.3s">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-5 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Liste des voyages planifiés</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Retrouvez l'historique complet et les détails</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto pb-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-4 whitespace-nowrap">Date de Départ</th>
                            <th class="px-4 py-4">Destination</th>
                            <th class="px-4 py-4">Véhicule</th>
                            <th class="px-4 py-4">Chauffeur</th>
                            <th class="px-4 py-4 text-center">Type</th>
                            <th class="px-4 py-4 text-right whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($voyages as $v)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($v->date_depart)->isoFormat('DD MMM YYYY à HH:mm') }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    {{ $v->destination }}
                                    @if($v->nb_passagers > 0)
                                        <span class="block text-xs text-gray-400 font-normal"><i class="fas fa-users mr-1"></i>{{ $v->nb_passagers }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    @if($v->vehicule)
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">{{ $v->vehicule->immatriculation }}</span>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    @if($v->chauffeur)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">
                                                {{ substr($v->chauffeur->nom, 0, 1) }}
                                            </div>
                                            <span>{{ $v->chauffeur->nom }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($v->type == 'maintenance')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Maintenance
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Mission
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('agent.voyages.show', $v->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition" title="Voir les détails">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('agent.voyages.edit', $v->id) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition" title="Modifier">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form action="{{ route('agent.voyages.destroy', $v->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce voyage ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Supprimer">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-route text-4xl text-gray-200 mb-3"></i>
                                        <p>Aucun voyage trouvé.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($voyages) && $voyages->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $voyages->links() }}
            </div>
            @endif
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

    /* Transition douce globale supprimée car dommageable pour FullCalendar */
    .fc-event {
        transition-property: transform, box-shadow, background-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 0.2s;
    }

    /* Fix pour l'affichage responsive de la toolbar FullCalendar (Mobile) */
    .fc .fc-toolbar.fc-header-toolbar {
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem !important;
    }
    .fc .fc-toolbar-chunk {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
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
events: "{{ route('agent.voyages.events') }}",
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
            fetch('/agent/voyages/' + info.event.id + '/move', {
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
                fetch('/agent/voyages/' + info.event.id, {
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


