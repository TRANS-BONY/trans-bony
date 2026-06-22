@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 p-6 shadow-xl">
        <div class="relative flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-ticket-alt text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Billets & Réservations</h1>
                    <p class="text-emerald-100 mt-1">Gestion des réservations passagers</p>
                </div>
            </div>
            <!-- Bouton pour créer dynamiquement (nécessite un voyage) -->
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 font-semibold text-gray-600">N° Billet</th>
                        <th class="p-4 font-semibold text-gray-600">Client</th>
                        <th class="p-4 font-semibold text-gray-600">Voyage</th>
                        <th class="p-4 font-semibold text-gray-600">Date Départ</th>
                        <th class="p-4 font-semibold text-gray-600">Montant</th>
                        <th class="p-4 font-semibold text-gray-600 text-center">Status</th>
                        <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $res)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="p-4 font-medium text-gray-900">{{ $res->numero_billet }}</td>
                            <td class="p-4">{{ $res->client->nom ?? 'Inconnu' }}</td>
                            <td class="p-4">{{ $res->voyage->destination ?? 'N/A' }}</td>
                            <td class="p-4">{{ $res->voyage ? \Carbon\Carbon::parse($res->voyage->date_depart)->format('d/m/Y H:i') : '' }}</td>
                            <td class="p-4 font-semibold text-gray-900">{{ number_format($res->montant, 0, ',', ' ') }} FCFA</td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    {{ ucfirst($res->statut) }}
                                </span>
                            </td>
                            <td class="p-4 text-right flex gap-2 justify-end">
                                @php
                                    // Utiliser la bonne route en fonction du rôle
                                    $role = auth()->user()->hasRole('admin') ? 'admin' : 'agent';
                                    $showRoute = route("$role.reservations.show", $res->id);
                                    $pdfRoute = route("$role.reservations.ticket", $res->id);
                                @endphp
                                <a href="{{ $showRoute }}" class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow transition">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ $pdfRoute }}" target="_blank" class="px-3 py-1.5 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 rounded-lg shadow transition">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">Aucune réservation trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reservations->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
