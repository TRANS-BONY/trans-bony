<?php

namespace App\Http\Controllers;

use App\Models\RecetteMensuelle;
use App\Models\Vehicule;
use App\Models\Voyage;
use App\Models\Chauffeur;
use App\Models\Rapport;
use Illuminate\Http\Request;

class ComptableController extends Controller
{
    /**
     * Dashboard Comptable
     */
    public function dashboard()
    {
        // Recettes du mois courant
        $recettes_mois = RecetteMensuelle::whereMonth('date', now()->month)
                                         ->whereYear('date', now()->year)
                                         ->sum('montant');

        // Total cumulé
        $recettes_total = RecetteMensuelle::sum('montant');

        // Mois précédent pour calcul évolution
        $prev          = now()->subMonth();
        $recettes_prec = RecetteMensuelle::whereMonth('date', $prev->month)
                                          ->whereYear('date', $prev->year)
                                          ->sum('montant');

        $recettes_evolution = $recettes_prec > 0
            ? round((($recettes_mois - $recettes_prec) / $recettes_prec) * 100, 1)
            : 0;

        // Barre progression (vs max mensuel connu)
        $recettes_max = RecetteMensuelle::selectRaw('SUM(montant) as total, YEAR(date) as y, MONTH(date) as m')
                                         ->groupBy('y', 'm')
                                         ->orderByDesc('total')
                                         ->value('total') ?: 1;
        $recettes_pct = min(100, round($recettes_mois / $recettes_max * 100));

        // Compteurs
        $nb_recettes      = RecetteMensuelle::count();
        $nb_recettes_mois = RecetteMensuelle::whereMonth('date', now()->month)
                                             ->whereYear('date', now()->year)
                                             ->count();
        $nb_rapports = Rapport::count();

        // Stats globales
        $vehicules  = Vehicule::count();
        $voyages    = Voyage::count();
        $chauffeurs = Chauffeur::count();

        // Dernières recettes (5)
        $dernieres_recettes = RecetteMensuelle::orderByDesc('date')->take(5)->get();

        // Graphique — 12 derniers mois
        $chart_labels = [];
        $chart_data   = [];
        for ($i = 11; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $chart_labels[] = $d->isoFormat('MMM YY');
            $chart_data[]   = (float) RecetteMensuelle::whereMonth('date', $d->month)
                                                        ->whereYear('date', $d->year)
                                                        ->sum('montant');
        }

        // Badge sidebar
        $sidebar_recettes = $nb_recettes;

        return view('comptable.index', compact(
            'recettes_mois',
            'recettes_total',
            'recettes_evolution',
            'recettes_pct',
            'nb_recettes',
            'nb_recettes_mois',
            'nb_rapports',
            'vehicules',
            'voyages',
            'chauffeurs',
            'dernieres_recettes',
            'chart_labels',
            'chart_data',
            'sidebar_recettes'
        ));
    }
}
