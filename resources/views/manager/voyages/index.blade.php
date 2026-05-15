@extends('layouts.manager')

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
                    <p class="text-orange-100 text-sm mt-1">Consultez et planifiez les missions et maintenances</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs text-white">En direct</span>
                </div>
            </div>
        </div>
    </div>    <!-- Contenu principal -->
    <div class="flex flex-col gap-6">
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
                            <p class="text-sm text-gray-500 mt-0.5">Consultez le planning des missions et maintenances</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div id='calendar' class="fullcalendar-custom"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-down { animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .animate-fade-in-up { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .fullcalendar-custom { font-family: inherit; }
    .fc { background: white; border-radius: 0.5rem; }
    .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 600; color: #1f2937; }
    .fc .fc-button-primary { background-color: #f97316; border-color: #f97316; transition: all 0.3s ease; }
    .fc .fc-button-primary:hover { background-color: #ea580c; border-color: #ea580c; transform: scale(1.05); }
    .fc .fc-button-primary:not(:disabled):active { background-color: #ea580c; border-color: #ea580c; }
    .fc .fc-daygrid-day { transition: background-color 0.2s ease; }
    .fc .fc-daygrid-day:hover { background-color: #fff7ed; }
    .fc-event { cursor: default; transition: transform 0.2s ease, box-shadow 0.2s ease; border: none; padding: 2px 4px; font-size: 0.8rem; }
    .fc-event:hover { transform: scale(1.02); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); }
    .fc-event.voyage-event { background-color: #3b82f6; border-left: 3px solid #1e40af; }
    .fc-event.maintenance-event { background-color: #f59e0b; border-left: 3px solid #b45309; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: false,
        selectable: false,
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
        events: "{{ route($rolePrefix . '.voyages.events') }}",
        eventDidMount: function(info) {
            if (info.event.extendedProps.type === 'maintenance') {
                info.el.classList.add('maintenance-event');
            } else {
                info.el.classList.add('voyage-event');
            }
            info.el.setAttribute('title', `${info.event.title} - Départ: ${info.event.start.toLocaleString()}`);
        },
        locale: 'fr',
        firstDay: 1,
        height: 'auto',
        contentHeight: 'auto'
    });

    calendar.render();
});
</script>
@endsection
