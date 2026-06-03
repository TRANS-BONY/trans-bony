<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\RecetteMensuelle;
use Carbon\Carbon;

echo "=== TEST : STATISTIQUES DU TABLEAU DE BORD ===\n\n";

// 1. Cartes statistiques principales
echo "--- CARTES KPI ---\n";
echo "Vehicules total      : " . Vehicule::count() . "\n";
echo "Chauffeurs total     : " . Chauffeur::count() . "\n";
echo "Voyages total        : " . Voyage::count() . "\n";
echo "Voyages ce mois      : " . Voyage::whereMonth('date_depart', now()->month)->whereYear('date_depart', now()->year)->count() . "\n";
echo "Maintenances total   : " . Maintenance::count() . "\n";

echo "\n--- FINANCES ---\n";
$recettes_total = RecetteMensuelle::sum('montant');
$recettes_mois  = RecetteMensuelle::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('montant');
$recettes_mois_prec = RecetteMensuelle::whereMonth('date', now()->subMonth()->month)->whereYear('date', now()->subMonth()->year)->sum('montant');
echo "Recettes totales     : " . number_format($recettes_total, 0, ',', ' ') . " FCFA\n";
echo "Recettes ce mois     : " . number_format($recettes_mois, 0, ',', ' ') . " FCFA\n";
echo "Recettes mois préc.  : " . number_format($recettes_mois_prec, 0, ',', ' ') . " FCFA\n";

// Evolution
if ($recettes_mois_prec > 0) {
    $evolution = round((($recettes_mois - $recettes_mois_prec) / $recettes_mois_prec) * 100, 1);
    echo "Évolution            : " . ($evolution >= 0 ? '+' : '') . $evolution . "%\n";
} else {
    echo "Évolution            : N/A (pas de mois précédent)\n";
}

echo "\n--- DONNÉES GRAPHIQUE (12 derniers mois) ---\n";
for ($i = 11; $i >= 0; $i--) {
    $d = now()->subMonths($i);
    $montant = (float) RecetteMensuelle::whereMonth('date', $d->month)->whereYear('date', $d->year)->sum('montant');
    echo $d->isoFormat('MMM YYYY') . " : " . number_format($montant, 0, ',', ' ') . " FCFA\n";
}

echo "\n--- STATUT MAINTENANCES ---\n";
echo "En cours             : " . Maintenance::where('statut', 'en cours')->count() . "\n";
echo "Planifiées           : " . Maintenance::where('statut', 'planifiee')->count() . "\n";
echo "Terminées            : " . Maintenance::where('statut', 'terminee')->count() . "\n";

echo "\n--- ALERTES KILOMÉRIQUE (seuil 5000 km) ---\n";
$vehicules = Vehicule::all();
$alertes = 0;
foreach ($vehicules as $v) {
    $last = Maintenance::where('vehicule_id', $v->id)->orderBy('date_prevue', 'desc')->first();
    if ($last && isset($last->compteur_km) && isset($v->km_actuel)) {
        $distance = $v->km_actuel - $last->compteur_km;
        if ($distance >= 5000) {
            echo "  ALERTE: " . $v->immatriculation . " — +" . number_format($distance - 5000, 0) . " km de dépassement\n";
            $alertes++;
        }
    }
}
if ($alertes === 0) {
    echo "  Aucune alerte kilométrique détectée\n";
}

echo "\n=== FIN DES TESTS ===\n";
