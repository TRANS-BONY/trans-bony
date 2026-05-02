@extends('layouts.gestionnaire')

@section('title', 'Gestion Documentaire')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Documents</h2>
        <a href="{{ route('gestionnaire.documents.create') }}" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-teal-500/20">
            <i class="fas fa-plus mr-2"></i> Ajouter un document
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 text-xs uppercase tracking-widest font-bold">
                        <th class="px-6 py-4">Véhicule</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Expiration</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($documents as $d)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $d->vehicule->immatriculation ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $d->type }}</td>
                        <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($d->date_expiration)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $isExpired = \Carbon\Carbon::parse($d->date_expiration)->isPast();
                                $isExpiringSoon = \Carbon\Carbon::parse($d->date_expiration)->diffInDays(now()) <= 30;
                            @endphp
                            <span class="px-2 py-1 text-[10px] font-bold rounded-lg uppercase
                                {{ $isExpired ? 'bg-red-100 text-red-700' : ($isExpiringSoon ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700') }}">
                                {{ $isExpired ? 'Expiré' : ($isExpiringSoon ? 'Bientôt' : 'Valide') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ asset('storage/' . $d->fichier) }}" target="_blank" class="p-2 text-gray-400 hover:text-teal-600"><i class="fas fa-download"></i></a>
                                <a href="{{ route('gestionnaire.documents.edit', $d) }}" class="p-2 text-gray-400 hover:text-blue-600"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('gestionnaire.documents.destroy', $d) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
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
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
