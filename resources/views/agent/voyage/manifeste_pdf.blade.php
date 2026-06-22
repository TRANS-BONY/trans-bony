<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Manifeste de Voyage - {{ $voyage->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11pt; color: #333; margin: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #f97316; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #f97316; }
        .manifest-title { font-size: 18px; margin-top: 10px; text-transform: uppercase; }
        
        .section-title { background-color: #f8f9fa; padding: 8px; font-weight: bold; margin: 20px 0 10px 0; border-left: 4px solid #f97316; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .info-label { font-weight: bold; width: 150px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-size: 10pt; }
        .data-table td { font-size: 9pt; }
        
        .summary { margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; text-align: right; }
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 9pt; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">TRANS-BONY LOGISTICS</div>
        <div class="manifest-title">Manifeste de Voyage</div>
        <div>Destination: {{ $voyage->destination }} | Date: {{ $voyage->date_depart->format('d/m/Y H:i') }}</div>
    </div>

    <div class="section-title">Informations Générales</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Véhicule:</td>
            <td>{{ $voyage->vehicule->immatriculation ?? 'N/A' }} ({{ $voyage->vehicule->marque }} {{ $voyage->vehicule->modele }})</td>
            <td class="info-label">Type:</td>
            <td>{{ ucfirst($voyage->type) }}</td>
        </tr>
        <tr>
            <td class="info-label">Chauffeur Principal:</td>
            <td>{{ $voyage->chauffeur_principal ? $voyage->chauffeur_principal->nom . ' ' . $voyage->chauffeur_principal->prenom : 'N/A' }}</td>
            <td class="info-label">Tel Chauffeur:</td>
            <td>{{ $voyage->chauffeur_principal->telephone ?? 'N/A' }}</td>
        </tr>
        @php $relais = $voyage->affectations->where('role_chauffeur', 'relais')->first(); @endphp
        @if($relais)
        <tr>
            <td class="info-label">Chauffeur Relais:</td>
            <td>{{ $relais->chauffeur->nom }} {{ $relais->chauffeur->prenom }}</td>
            <td class="info-label">Tel Relais:</td>
            <td>{{ $relais->chauffeur->telephone ?? 'N/A' }}</td>
        </tr>
        @endif
    </table>

    <div class="section-title">Liste des Passagers</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Billet N°</th>
                <th>Nom du Client / Passager</th>
                <th>Siège</th>
                <th>Contact</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPassagers = 0; @endphp
            @forelse($voyage->reservations()->where('statut', '!=', 'annulee')->get() as $index => $res)
                @php $totalPassagers += $res->nb_passagers; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $res->numero_billet }}</td>
                    <td>{{ $res->client->full_name }} @if($res->nb_passagers > 1) + {{ $res->nb_passagers - 1 }} pers. @endif</td>
                    <td>{{ $res->siege ?? '-' }}</td>
                    <td>{{ $res->client->telephone }}</td>
                    <td>{{ ucfirst($res->statut) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888;">Aucun passager enregistré pour ce voyage.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Liste des Colis / Marchandises</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Expéditeur</th>
                <th>Nb Colis</th>
                <th>Poids (kg)</th>
                <th>Notes / Nature</th>
            </tr>
        </thead>
        <tbody>
            @php $totalColis = 0; $totalPoids = 0; @endphp
            @forelse($voyage->reservations()->where('nb_colis', '>', 0)->get() as $index => $res)
                @php $totalColis += $res->nb_colis; $totalPoids += $res->poids_colis_kg; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $res->client->full_name }}</td>
                    <td>{{ $res->nb_colis }}</td>
                    <td>{{ $res->poids_colis_kg ?? '0' }}</td>
                    <td>{{ $res->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #888;">Aucun colis enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Récapitulatif :</strong> {{ $totalPassagers }} Passagers | {{ $totalColis }} Colis | {{ $totalPoids }} kg
    </div>

    <div class="footer">
        TRANS-BONY Logistics - Document généré le {{ now()->format('d/m/Y H:i') }} - Page 1/1
    </div>
</body>
</html>
