@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 p-6 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-xl"><i class="fas fa-plus text-2xl text-white"></i></div>
            <div>
                <h1 class="text-2xl font-bold text-white">Nouvelle Réservation</h1>
                <p class="text-emerald-100 mt-1">Voyage vers {{ $voyage->destination }} le {{ \Carbon\Carbon::parse($voyage->date_depart)->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route(auth()->user()->hasRole('admin') ? 'admin.reservations.store' : 'agent.reservations.store') }}" class="bg-white p-8 rounded-2xl shadow-xl space-y-6">
        @csrf
        <input type="hidden" name="voyage_id" value="{{ $voyage->id }}">

        <!-- Choix du client -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionner un Client</label>
            <select name="client_id" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                <option value="">-- Choisir un client --</option>
                @foreach($clients as $c)
                    <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>{{ $c->nom }} ({{ $c->email ?? $c->telephone }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de passagers</label>
                <input type="number" name="nb_passagers" value="{{ old('nb_passagers', 1) }}" min="1" class="w-full px-4 py-3 rounded-xl border border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Montant (FCFA)</label>
                <input type="number" name="montant" value="{{ old('montant') }}" min="0" class="w-full px-4 py-3 rounded-xl border border-gray-300" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mode de paiement</label>
                <select name="mode_paiement" class="w-full px-4 py-3 rounded-xl border border-gray-300" required>
                    <option value="espece">Espèce</option>
                    <option value="mobile_money">Mobile Money</option>
                    <option value="virement">Virement</option>
                    <option value="en_attente">En attente</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Siège (Optionnel)</label>
                <input type="text" name="siege" placeholder="Ex: A12" class="w-full px-4 py-3 rounded-xl border border-gray-300">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300"></textarea>
        </div>

        <!-- Colis liés (Optionnel) -->
        <input type="hidden" name="nb_colis" value="0">
        <input type="hidden" name="poids_colis_kg" value="0">

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg transition text-lg mt-6">
            Confirmer la réservation
        </button>
    </form>
</div>
@endsection
