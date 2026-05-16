<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #1e293b; 
            line-height: 1.6; 
            margin: 0;
            padding: 0;
        }
        .container { padding: 40px; }
        .sidebar-accent {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 10px;
            background: linear-gradient(to bottom, #ec4899, #d946ef);
        }
        .header { 
            margin-bottom: 50px; 
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .brand { font-size: 28px; font-weight: 900; color: #ec4899; letter-spacing: -1px; }
        .brand span { color: #d946ef; }
        .report-title { 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            color: #64748b; 
            margin-top: 5px; 
        }
        .date-box {
            position: absolute;
            top: 40px;
            right: 40px;
            text-align: right;
            font-size: 12px;
            color: #64748b;
        }
        
        .section-title { 
            font-size: 14px; 
            font-weight: 800; 
            color: #0f172a; 
            margin-bottom: 20px; 
            padding-bottom: 8px;
            border-bottom: 2px solid #f1f5f9;
        }
        
        .stats-grid { 
            width: 100%; 
            margin-bottom: 40px; 
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 12px;
            width: 30%;
        }
        .stat-label { 
            font-size: 9px; 
            color: #94a3b8; 
            text-transform: uppercase; 
            font-weight: bold; 
            margin-bottom: 8px; 
            display: block;
        }
        .stat-value { 
            font-size: 22px; 
            color: #1e293b; 
            font-weight: 800; 
        }
        .stat-value.currency { color: #db2777; }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 50px;
        }
        .details-table th {
            background: #f8fafc;
            text-align: left;
            padding: 12px;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
        }
        .details-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }

        .summary-box {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 12px;
            font-size: 12px;
            color: #475569;
        }

        .signature-section {
            margin-top: 80px;
            width: 100%;
        }
        .signature-box {
            width: 200px;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
        }

        .footer { 
            position: fixed; 
            bottom: 20px; 
            left: 40px;
            right: 40px;
            text-align: center; 
            font-size: 9px; 
            color: #94a3b8; 
        }
    </style>
</head>
<body>
    <div class="sidebar-accent"></div>
    
    <div class="container">
        <div class="header">
            <div class="brand">TRANS <span>BONY</span></div>
            <div class="report-title">Suivi Consommation Carburant</div>
            <div class="date-box">
                Généré le {{ now()->format('d/m/Y') }}<br>
                Réf: FUEL-{{ now()->format('Ymd') }}-{{ rand(100, 999) }}
            </div>
        </div>

        <div class="section-title">Résumé Analytique</div>
        <table class="stats-grid" cellspacing="10">
            <tr>
                <td class="stat-card">
                    <span class="stat-label">Volume Total</span>
                    <span class="stat-value">{{ number_format($stats['total_litres'], 1, ',', ' ') }} L</span>
                </td>
                <td class="stat-card">
                    <span class="stat-label">Nombre de Pleins</span>
                    <span class="stat-value">{{ $stats['nb_pleins'] }}</span>
                </td>
                <td class="stat-card">
                    <span class="stat-label">Coût Total</span>
                    <span class="stat-value currency">{{ number_format($stats['total_montant'], 0, ',', ' ') }} <span style="font-size: 12px;">FCFA</span></span>
                </td>
            </tr>
        </table>

        <div class="section-title">Détail des Opérations</div>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Véhicule</th>
                    <th>Station</th>
                    <th style="text-align: right;">Litres</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carburants as $c)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($c->date)->format('d/m/Y') }}</td>
                    <td><span style="font-weight: bold;">{{ $c->vehicule->immatriculation }}</span></td>
                    <td>{{ $c->station ?? 'N/A' }}</td>
                    <td style="text-align: right;">{{ number_format($c->quantite, 1) }} L</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($c->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-box">
            <strong>Certification :</strong> Ce rapport de consommation de carburant est certifié conforme aux saisies effectuées sur la plateforme TRANS BONY. Les montants indiqués sont exprimés en Franc CFA (XAF).
        </div>

        <table class="signature-section">
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <div class="signature-box">
                        Le Gestionnaire de Flotte<br><br><br><br>
                        <strong>Fait à Brazzaville, le {{ now()->format('d/m/Y') }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            TRANS BONY — Système de Gestion de Flotte — Rapport Carburant Confidentiel.
        </div>
    </div>
</body>
</html>
