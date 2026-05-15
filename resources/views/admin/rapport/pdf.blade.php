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
            background: linear-gradient(to bottom, #4f46e5, #9333ea);
        }
        .header { 
            margin-bottom: 50px; 
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .brand { font-size: 28px; font-weight: 900; color: #4f46e5; letter-spacing: -1px; }
        .brand span { color: #9333ea; }
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
        .stat-value.currency { color: #10b981; }

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
            <div class="report-title">Rapport d'Activité Officiel</div>
            <div class="date-box">
                Généré le {{ now()->format('d/m/Y') }}<br>
                Réf: TB-{{ now()->format('Ymd') }}-{{ rand(100, 999) }}
            </div>
        </div>

        <div class="section-title">Indicateurs de Performance</div>
        <table class="stats-grid" cellspacing="10">
            <tr>
                <td class="stat-card">
                    <span class="stat-label">Flotte Active</span>
                    <span class="stat-value">{{ $vehicules }}</span>
                </td>
                <td class="stat-card">
                    <span class="stat-label">Missions Totales</span>
                    <span class="stat-value">{{ $voyages }}</span>
                </td>
                <td class="stat-card">
                    <span class="stat-label">Revenus Consolidés</span>
                    <span class="stat-value currency">{{ number_format($recettes, 0, ',', ' ') }} <span style="font-size: 12px;">FCFA</span></span>
                </td>
            </tr>
        </table>

        <div class="section-title">Récapitulatif des Données</div>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th style="text-align: right;">Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Logistique</td>
                    <td>Nombre total de véhicules enregistrés</td>
                    <td style="text-align: right; font-weight: bold;">{{ $vehicules }}</td>
                </tr>
                <tr>
                    <td>Opérations</td>
                    <td>Volume de voyages effectués sur la période</td>
                    <td style="text-align: right; font-weight: bold;">{{ $voyages }}</td>
                </tr>
                <tr>
                    <td>Finance</td>
                    <td>Chiffre d'affaires global généré</td>
                    <td style="text-align: right; font-weight: bold; color: #10b981;">{{ number_format($recettes, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-box">
            <strong>Note de Direction :</strong> Ce document atteste de la performance opérationnelle de la société TRANS BONY. Les données ci-dessus sont extraites en temps réel de la plateforme de gestion.
        </div>

        <table class="signature-section">
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <div class="signature-box">
                        Cachet et Signature de la Direction<br><br><br><br>
                        <strong>Fait à Abidjan, le {{ now()->format('d/m/Y') }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            TRANS BONY — Plateforme de Gestion de Transport — Tous droits réservés.
        </div>
    </div>
</body>
</html>
