@extends('layouts.gestionnaire')

@section('title', 'Suivi Technique')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Maintenances</h2>
    </div>
    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 text-xs uppercase tracking-widest font-bold">
                        <th class="px-6 py-4">Véhicule</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($maintenances as $m)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $m->vehicule->immatriculation ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $m->type }}</td>
                        <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($m->date_prevue)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-[10px] font-bold rounded-lg uppercase
                                {{ $m->statut == 'terminee' ? 'bg-emerald-100 text-emerald-700' : ($m->statut == 'en cours' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ $m->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('gestionnaire.maintenances.show', $m) }}" class="p-2 text-gray-400 hover:text-teal-600"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $maintenances->links() }}
        </div>
    </div>
</div>
@endsection
