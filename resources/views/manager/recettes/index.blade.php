@extends('layouts.manager')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Finances & Recettes</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Suivi financier des opérations</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-medium">Date</th>
                        <th class="p-4 font-medium">Véhicule</th>
                        <th class="p-4 font-medium">Montant</th>
                        <th class="p-4 font-medium">Type</th>
                        <th class="p-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($recettes as $r)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="p-4">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $r->date->format('d/m/Y') }}</p>
                        </td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $r->vehicule->immatriculation ?? 'N/A' }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ number_format($r->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $r->type }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('manager.recettes.show', $r) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-500">Aucune recette enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recettes->hasPages())
        <div class="p-4 bg-gray-50">{{ $recettes->links() }}</div>
        @endif
    </div>
</div>
@endsection
