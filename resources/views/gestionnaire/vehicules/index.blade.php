@extends('layouts.gestionnaire')

@section('title', 'Gestion du Parc')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Véhicules</h2>
        <a href="{{ route('gestionnaire.vehicules.create') }}" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-teal-500/20">
            <i class="fas fa-plus mr-2"></i> Nouveau véhicule
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 text-xs uppercase tracking-widest font-bold">
                        <th class="px-6 py-4">Immatriculation</th>
                        <th class="px-6 py-4">Modèle</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Capacité</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($vehicules as $v)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $v->immatriculation }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $v->marque }} {{ $v->modele }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-[10px] font-bold rounded-lg uppercase
                                {{ $v->statut == 'disponible' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $v->statut == 'maintenance' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $v->statut == 'mission' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ $v->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $v->capacite }} places</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('gestionnaire.vehicules.show', $v) }}" class="p-2 text-gray-400 hover:text-teal-600"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('gestionnaire.vehicules.edit', $v) }}" class="p-2 text-gray-400 hover:text-blue-600"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('gestionnaire.vehicules.destroy', $v) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $vehicules->links() }}
        </div>
    </div>
</div>
@endsection
