<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Billet Trans-Bony - {{ $reservation->numero_billet }}</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .ticket { background-color: #fff; width: 100%; height: 100%; border-radius: 15px; overflow: hidden; box-shadow: 0 0 20px rgba(0,0,0,0.1); border: 2px solid #eee; position: relative; }
        
        /* Sidebar avec logo */
        .sidebar { width: 30%; height: 100%; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; float: left; padding: 20px; text-align: center; }
        .logo { font-size: 24px; font-bold; margin-bottom: 20px; border-bottom: 2px solid rgba(255,255,255,0.2); padding-bottom: 10px; }
        .qr-code { background: white; padding: 10px; border-radius: 10px; display: inline-block; margin-top: 10px; }
        .qr-img { width: 120px; height: 120px; }
        
        /* Main content */
        .content { width: 70%; float: left; padding: 30px; box-sizing: border-box; }
        .header { margin-bottom: 30px; }
        .title { font-size: 14px; text-transform: uppercase; color: #999; margin-bottom: 5px; }
        .destination { font-size: 32px; font-weight: bold; color: #222; }
        
        .info-grid { margin-top: 20px; }
        .info-item { width: 50%; float: left; margin-bottom: 20px; }
        .label { font-size: 10px; color: #777; text-transform: uppercase; margin-bottom: 5px; }
        .value { font-size: 16px; font-weight: bold; color: #333; }
        
        .footer { position: absolute; bottom: 20px; right: 20px; text-align: right; }
        .footer-text { font-size: 10px; color: #999; }
        
        .status-badge { background-color: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; display: inline-block; margin-top: 10px; }
        .ticket-number { font-size: 18px; font-weight: bold; color: #f97316; margin-top: 5px; }

        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="sidebar">
            <div class="logo">TRANS-BONY</div>
            <div class="qr-code">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(120)->generate($qrData)) !!} " class="qr-img">
            </div>
            <p style="font-size: 10px; margin-top: 15px; opacity: 0.8;">Scannez pour vérification</p>
            <div class="ticket-number" style="color: white; margin-top: 20px;">
                <span style="font-size: 10px; opacity: 0.7;">Billet N°</span><br>
                {{ $reservation->numero_billet }}
            </div>
        </div>
        
        <div class="content">
            <div class="header">
                <div class="title">Destination</div>
                <div class="destination">{{ $reservation->voyage->destination }}</div>
                <div class="status-badge">PAYÉ - CONFIRMÉ</div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Passager(s)</div>
                    <div class="value">{{ $reservation->client->full_name }} ({{ $reservation->nb_passagers }} PERS)</div>
                </div>
                <div class="info-item">
                    <div class="label">Date & Heure</div>
                    <div class="value">{{ $reservation->voyage->date_depart->format('d/m/Y') }} à {{ $reservation->voyage->date_depart->format('H:i') }}</div>
                </div>
                <div class="clear"></div>
                
                <div class="info-item">
                    <div class="label">Véhicule</div>
                    <div class="value">{{ $reservation->voyage->vehicule->immatriculation ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Siège(s)</div>
                    <div class="value">{{ $reservation->siege ?? 'Standard' }}</div>
                </div>
                <div class="clear"></div>
                
                <div class="info-item">
                    <div class="label">Bagages / Colis</div>
                    <div class="value">{{ $reservation->nb_colis }} colis ({{ $reservation->poids_colis_kg ?? '0' }} kg)</div>
                </div>
                <div class="info-item">
                    <div class="label">Montant</div>
                    <div class="value">{{ number_format($reservation->montant, 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="footer">
                <div class="footer-text">TRANS-BONY Logistics & Transport</div>
                <div class="footer-text">Généré le {{ date('d/m/Y H:i') }}</div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
