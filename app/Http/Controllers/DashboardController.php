<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Models\RecetteMensuelle;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $role  = strtolower($roles->first() ?? 'agent');

        // ── Véhicules ──────────────────────────────────────────
        $vehicules              = Vehicule::count();
        $vehicules_disponibles  = Vehicule::where('statut', 'disponible')->count();
        $vehicules_mission      = Vehicule::where('statut', 'mission')->count();
        $vehicules_maintenance  = Vehicule::where('statut', 'maintenance')->count();
        $nb_vehicules           = $vehicules; // Alias pour technicien

        // ── Chauffeurs ─────────────────────────────────────────
        $chauffeurs = Chauffeur::count();
        $chauffeurs_actifs = Chauffeur::where('actif', 1)->count();
        $chauffeurs_disponibles = $chauffeurs_actifs; // Hypothèse : actifs = disponibles
        $chauffeurs_mission     = 0;
        $chauffeurs_conge       = 0;

        // ── Voyages ────────────────────────────────────────────
        $voyages       = Voyage::count();
        $voyages_mois  = Voyage::whereMonth('date_depart', now()->month)
                               ->whereYear('date_depart', now()->year)
                               ->count();
        $voyages_today = Voyage::whereDate('date_depart', today())->count();

        // ── Maintenances ───────────────────────────────────────
        $maintenances           = Maintenance::count();
        $maintenances_en_cours  = Maintenance::where('statut', 'en cours')->count();
        $maintenances_planifiees = Maintenance::where('statut', 'planifiee')->count();
        $maintenances_terminees  = Maintenance::where('statut', 'terminee')->count();
        $maintenance_cout_total = Maintenance::sum('cout');
        $dernieres_maintenances = Maintenance::with('vehicule')->latest()->take(5)->get();

        // ── Documents ──────────────────────────────────────────
        $documents      = Document::count();
        $docs_expire    = Document::where('date_expiration', '<', Carbon::now())->count();
        $docs_bientot   = Document::whereBetween('date_expiration', [
            Carbon::now(),
            Carbon::now()->addDays(30),
        ])->count();

        // ── Alertes ────────────────────────────────────────────
        $alertes = Document::where('date_expiration', '<=', Carbon::now()->addDays(7))->count();
        $alertes_critiques = Document::where('date_expiration', '<', Carbon::now())->count();
        $alertes_mineures  = Document::whereBetween('date_expiration', [
            Carbon::now(),
            Carbon::now()->addDays(7),
        ])->count();

        // ── Recettes ───────────────────────────────────────────
        $recettes       = RecetteMensuelle::whereMonth('date', now()->month)
                                          ->whereYear('date', now()->year)
                                          ->sum('montant');
        $recettes_mois  = $recettes; // Alias pour comptable
        $recettes_total = RecetteMensuelle::sum('montant');
        $recettes_mois_prec = RecetteMensuelle::whereMonth('date', now()->subMonth()->month)
                                               ->whereYear('date', now()->subMonth()->year)
                                               ->sum('montant');

        // Évolution recette en % vs mois précédent
        $recettes_evolution = $recettes_mois_prec > 0
            ? round((($recettes - $recettes_mois_prec) / $recettes_mois_prec) * 100, 1)
            : 0;

        // Barre de progression recette
        $recettes_max  = RecetteMensuelle::selectRaw('SUM(montant) as total, YEAR(date) as y, MONTH(date) as m')
                                         ->groupBy('y', 'm')
                                         ->orderBy('total', 'desc')
                                         ->value('total') ?: 1;
        $recettes_pct  = $recettes_max > 0 ? min(100, round($recettes / $recettes_max * 100)) : 0;

        // ── Utilisateurs (admin seulement) ─────────────────────
        $users = $user->hasRole('admin') ? User::count() : 0;

        // ── Taux d'occupation ──────────────────────────────────
        $total_parc  = $vehicules_disponibles + $vehicules_mission + $vehicules_maintenance;
        $occupation  = $total_parc > 0 ? round(($vehicules_mission / $total_parc) * 100, 1) : 0;

        // ── Statistiques Financières (Rentabilité) ────────────────
        $totalRecettes    = RecetteMensuelle::sum('montant');
        $totalCarburant   = \App\Models\Carburant::sum('montant');
        $totalMaintenance = \App\Models\Maintenance::sum('cout');
        
        $totalDepenses = $totalCarburant + $totalMaintenance;
        $beneficeNet   = $totalRecettes - $totalDepenses;

        // ── Graphique (12 derniers mois) ──────────────────────
        // Optimisation : Une seule requête groupée au lieu de 12 requêtes
        $startDate = now()->subMonths(11)->startOfMonth();
        $recettes_groupes = RecetteMensuelle::selectRaw('SUM(montant) as total, YEAR(date) as annee, MONTH(date) as mois')
                                            ->where('date', '>=', $startDate)
                                            ->groupBy('annee', 'mois')
                                            ->get()
                                            ->keyBy(function($item) {
                                                return $item->annee . '-' . $item->mois;
                                            });

        $chart_labels = [];
        $chart_data   = [];
        for ($i = 11; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $key = $d->year . '-' . $d->month;
            $chart_labels[] = $d->isoFormat('MMM YY');
            $chart_data[]   = (float) ($recettes_groupes->has($key) ? $recettes_groupes[$key]->total : 0);
        }

        // ── Dernières données ──────────────────────────────────
        $dernieres_recettes = RecetteMensuelle::with('vehicule')->orderByDesc('date')->take(5)->get();
        $derniers_voyages   = Voyage::with(['vehicule', 'chauffeur'])->orderByDesc('date_depart')->take(5)->get();
        $derniers_vehicules = Vehicule::latest()->take(5)->get();
        $derniers_chauffeurs = Chauffeur::latest()->take(5)->get();

        // ── Rapports ──────────────────────────────────────────
        $nb_rapports = \App\Models\Rapport::count();
        $nb_recettes = RecetteMensuelle::count();
        $nb_recettes_mois = RecetteMensuelle::whereMonth('date', now()->month)
                                           ->whereYear('date', now()->year)
                                           ->count();

        // ── Tableau $stats pour la compatibilité (Gestionnaire, etc.)
        $stats = [
            'vehicules'              => $vehicules,
            'vehicules_disponibles'  => $vehicules_disponibles,
            'vehicules_mission'      => $vehicules_mission,
            'vehicules_maintenance'  => $vehicules_maintenance,
            'chauffeurs'             => $chauffeurs,
            'chauffeurs_actifs'      => $chauffeurs_actifs,
            'chauffeurs_disponibles' => $chauffeurs_disponibles,
            'chauffeurs_mission'     => $chauffeurs_mission,
            'chauffeurs_conge'       => $chauffeurs_conge,
            'voyages'                => $voyages,
            'voyages_mois'           => $voyages_mois,
            'voyages_today'          => $voyages_today,
            'maintenances'           => $maintenances,
            'maintenances_en_cours'  => $maintenances_en_cours,
            'maintenances_planifiees' => $maintenances_planifiees,
            'documents'              => $documents,
            'documents_expirant'     => $alertes,
            'recettes_mois'          => $recettes,
            'recettes_total'         => $recettes_total,
            'occupation'             => $occupation,
            'carburant_mois'         => \App\Models\Carburant::whereMonth('date', now()->month)->sum('montant'),
            'nb_pleins'              => \App\Models\Carburant::count(),
        ];

        // ── Vue selon le rôle ──────────────────────────────────
        $view = 'admin.index';
        if ($role === 'comptable')    $view = 'comptable.index';
        if ($role === 'manager')      $view = 'manager.dashboard';
        if ($role === 'agent')        $view = 'agent.index';
        if ($role === 'technicien')   $view = 'technicien.dashboard';
        if ($role === 'gestionnaire') $view = 'gestionnaire.dashboard';

        // ── Maintenances à prévoir (Alertes Kilométrage) ────────
        $seuil_maintenance = 5000; // km
        
        // Optimisation : Utiliser eager loading pour éviter le N+1
        $vehicules_alerte_km = Vehicule::with(['maintenances' => function($q) {
            $q->where('statut', 'terminee')->orderByDesc('updated_at');
        }])->get()->map(function($v) use ($seuil_maintenance) {
            $derniere_maintenance = $v->maintenances->first();
            $km_derniere = $derniere_maintenance ? $derniere_maintenance->compteur_km : 0;
            $distance_parcourue = $v->kilometrage - $km_derniere;
            
            if ($distance_parcourue >= $seuil_maintenance) {
                return [
                    'id' => $v->id,
                    'immatriculation' => $v->immatriculation,
                    'distance' => $distance_parcourue,
                    'depassement' => $distance_parcourue - $seuil_maintenance
                ];
            }
            return null;
        })->filter()->values()->all();

        $nb_alertes_maintenance_km = count($vehicules_alerte_km);

        return view($view, compact(
            'role',
            'stats',
            'vehicules', 'vehicules_disponibles', 'vehicules_mission', 'vehicules_maintenance', 'derniers_vehicules', 'nb_vehicules',
            'chauffeurs', 'chauffeurs_actifs', 'chauffeurs_disponibles', 'chauffeurs_mission', 'chauffeurs_conge', 'derniers_chauffeurs',
            'voyages', 'voyages_mois', 'voyages_today', 'derniers_voyages',
            'maintenances', 'maintenances_en_cours', 'maintenances_planifiees', 'maintenances_terminees', 'maintenance_cout_total', 'dernieres_maintenances',
            'documents', 'docs_expire', 'docs_bientot', 'alertes', 'alertes_critiques', 'alertes_mineures',
            'recettes', 'recettes_mois', 'recettes_total', 'recettes_evolution', 'recettes_pct', 'dernieres_recettes',
            'chart_labels', 'chart_data',
            'users',
            'occupation',
            'nb_rapports', 'nb_recettes', 'nb_recettes_mois',
            'vehicules_alerte_km', 'nb_alertes_maintenance_km',
            'totalRecettes', 'totalDepenses', 'beneficeNet'
        ));
    }
}
