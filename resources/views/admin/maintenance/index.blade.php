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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 9l4-4 4 4" stroke="currentColor"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        Gestion des Maintenances
                    </h1>
                    <p class="text-amber-100 text-sm mt-1">Suivez et planifiez les maintenances de votre flotte</p>
                </div>
            </div>
            <a href="{{ route('admin.maintenances.create') }}"
               class="group relative overflow-hidden px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm">
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-white font-medium">Ajouter une maintenance</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Barre de recherche avancée -->
    <div class="relative animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="relative overflow-hidden rounded-xl bg-white shadow-md border border-gray-200">
            <div class="relative flex items-center">
                <div class="pl-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <form method="GET" class="flex-1">
                    <input type="text"
                           name="search"
                           placeholder="Rechercher par véhicule, type de maintenance..."
                           value="{{ request('search') }}"
                           class="w-full p-3 bg-transparent text-gray-700 placeholder-gray-400 focus:outline-none">
                </form>
@if(request('search'))\n                <a href="{{ route('admin.maintenances.index') }}" class="pr-4">\n                    <svg class="w-5 h-5 text-gray-400 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">\n                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>\n                    </svg>\n                </a>\n                @endif
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in-up" style="animation-delay: 0.2s">
        <!-- Total Maintenances -->
        <div class="rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-100 uppercase tracking-wider">Total</p>
                    <p class="text-3xl font-bold text-white">{{ $maintenances->count() }}</p>

                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- À venir -->
        <div class="rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-sky-100 uppercase tracking-wider">À venir</p>
                    <p class="text-3xl font-bold text-white">{{ $maintenances->where('date_prevue', '>=', now())->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Coût total -->
        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-100 uppercase tracking-wider">Coût total</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($maintenances->sum('cout'), 0) }} FCFA</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Urgence -->
        <div class="rounded-xl bg-gradient-to-br from-red-500 to-red-600 p-4 transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-red-100 uppercase tracking-wider">En retard</p>
                    <p class="text-3xl font-bold text-white">{{ $maintenances->where('date_prevue', '<', now())->count() }}</p>
                </div>
                <div class="p-2 rounded-lg bg-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des maintenances -->
    <div class="rounded-2xl bg-white border border-gray-200 overflow-hidden shadow-xl animate-fade-in-up" style="animation-delay: 0.3s">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Véhicule</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Date prévue</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Coût</th>
                        <th class="p-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($maintenances as $m)
                    <tr class="hover:bg-gray-50 transition-all duration-300 group">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span class="font-semibold text-gray-900">{{ $m->vehicule?->immatriculation ?? 'N/A' }}</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $m->vehicule?->marque ?? '' }} {{ $m->vehicule?->modele ?? '' }}</div>
                        </td>
                        <td class="p-4">
                            @php
                                $typeConfig = [
                                    'préventive' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Préventive'],
                                    'curative' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'label' => 'Curative'],
                                    'urgente' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Urgente']
                                ];
                                $config = $typeConfig[$m->type] ?? $typeConfig['préventive'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                </svg>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-700">{{ \Carbon\Carbon::parse($m->date_prevue)->format('d/m/Y') }}</span>
                            </div>
                            @if(\Carbon\Carbon::parse($m->date_prevue)->isPast())
                                <span class="inline-flex items-center gap-1 text-xs text-red-500 mt-1">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                    </span>
                                    En retard
                                </span>
                            @elseif(\Carbon\Carbon::parse($m->date_prevue)->diffInDays(now()) <= 7)
                                <span class="inline-flex items-center gap-1 text-xs text-amber-500 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Proche
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-bold text-green-600">{{ number_format($m->cout, 2) }} FCFA</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.maintenances.show', $m) }}"
                                   class="group/btn p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-all duration-300 hover:scale-110"
                                   title="Voir les détails">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.maintenances.edit', $m) }}"
                                   class="group/btn p-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition-all duration-300 hover:scale-110"
                                   title="Modifier la maintenance">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.maintenances.destroy', $m) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette maintenance ?\n\nVéhicule : {{ $m->vehicule?->immatriculation ?? 'N/A' }}\nType : {{ $m->type }}\nDate : {{ \Carbon\Carbon::parse($m->date_prevue)->format('d/m/Y') }}\n\nCette action est irréversible.')"
                                            class="p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-all duration-300 hover:scale-110"
                                            title="Supprimer la maintenance">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="p-4 rounded-full bg-gray-100">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-700">Aucune maintenance trouvée</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        @if(request('search'))
                                            Aucun résultat pour "{{ request('search') }}"
                                        @else
                                            Commencez par ajouter une maintenance
                                        @endif
                                    </p>
                                </div>
                                @if(!request('search'))
                                <a href="{{ route('admin.maintenances.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all duration-300 hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Ajouter une maintenance
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($maintenances->hasPages())
        <div class="border-t border-gray-200 p-4 bg-gradient-to-r from-gray-50 to-white">
            {{ $maintenances->appends(request()->query())->links() }}
        </div>
        @endif
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

    /* Style pour la pagination */
    nav[aria-label="Pagination"] {
        display: flex;
        justify-content: center;
    }

    nav[aria-label="Pagination"] .relative {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #e5e7eb;
        color: #374151;
        transition: all 0.3s ease;
    }

    nav[aria-label="Pagination"] .relative:hover {
        background: #f97316;
        border-color: #f97316;
        color: white;
        transform: scale(1.05);
    }

    nav[aria-label="Pagination"] .relative[aria-current="page"] span {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        border: none;
    }

    /* Animation pour les lignes du tableau */
    tbody tr {
        animation: fadeInUp 0.4s ease-out forwards;
        opacity: 0;
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
    document.addEventListener('DOMContentLoaded', function() {
        // Animation de transition pour les lignes du tableau avec délais progressifs
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
    });
</script>

@endsection
