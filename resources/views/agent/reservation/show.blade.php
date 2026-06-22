@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-gray-800 to-gray-900 p-6 shadow-xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/10 rounded-xl">
                    <i class="fas fa-ticket-alt text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Billet N° {{ $reservation->numero_billet }}</h1>
                    <p class="text-gray-300 mt-1">Généré le {{ $reservation->created_at->format('d/m/Y') }} par TRANS BONY</p>
                </div>
            </div>
            @php
                $role = auth()->user()->hasRole('admin') ? 'admin' : (auth()->user()->hasRole('agent') ? 'agent' : 'client');
                $pdfRoute = $role === 'client' ? '#' : route("$role.reservations.ticket", $reservation->id);
            @endphp
            <a href="{{ $pdfRoute }}" target="_blank" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg transition">
                <i class="fas fa-print mr-2"></i> Imprimer
            </a>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-xl flex gap-8">
        <div class="flex-1 space-y-6">
            <div>
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-2">Informations Passager</h3>
                <p class="text-xl font-bold text-gray-900">{{ $reservation->client->nom }}</p>
                <p class="text-gray-600"><i class="fas fa-phone mr-2"></i> {{ $reservation->client->telephone ?? 'Non renseigné' }}</p>
            </div>
            
            <hr class="border-gray-100">

            <div>
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-2">Détails du Voyage</h3>
                <p class="text-xl font-bold text-emerald-600 mb-1"><i class="fas fa-map-marker-alt mr-2"></i> {{ $reservation->voyage->destination }}</p>
                <p class="text-gray-800 font-semibold mb-1"><i class="fas fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::parse($reservation->voyage->date_depart)->format('d/m/Y à H:i') }}</p>
                <p class="text-gray-600"><i class="fas fa-bus mr-2"></i> Bus: {{ $reservation->voyage->vehicule->immatriculation ?? 'Non assigné' }}</p>
            </div>

            <hr class="border-gray-100">

            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl">
                <div>
                    <p class="text-sm text-gray-500">Montant payé</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($reservation->montant, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Méthode</p>
                    <p class="font-semibold uppercase">{{ $reservation->mode_paiement }}</p>
                </div>
            </div>
        </div>

        <div class="w-1/3 flex flex-col items-center justify-center bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-200">
            <h3 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4">Code de vérification</h3>
            <!-- Affichage du QR Code (Exemple statique si on n'a pas la librairie dans ce snippet, mais possible d'utiliser celle de Laravel) -->
            <div class="w-48 h-48 bg-white p-2 rounded-xl shadow-sm mb-4">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(175)->generate($reservation->numero_billet) !!}
            </div>
            <p class="text-center text-xs text-gray-500 mt-2">Veuillez présenter ce code à l'embarquement.</p>
        </div>
    </div>
</div>
@endsection
