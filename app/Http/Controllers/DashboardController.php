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
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $role  = strtolower($roles->first() ?? 'agent');

        // ── Véhicules ──────────────────────────────────────────
        $vehicules              = Vehicule::count();
        $vehicules_disponibles  = Vehicule::where('statut', 'disponible')->count();
        $vehicules_mission      = Vehicule::where('statut', 'mission')->count();
        $vehicules_maintenance  = Vehicule::where('statut', 'maintenance')->count();

        // ── Chauffeurs ─────────────────────────────────────────
        $chauffeurs = Chauffeur::count();

        // ── Voyages ────────────────────────────────────────────
        $voyages       = Voyage::count();
        $voyages_mois  = Voyage::whereMonth('date_depart', now()->month)
                               ->whereYear('date_depart', now()->year)
                               ->count();
        $voyages_today = Voyage::whereDate('date_depart', today())->count();

        // ── Maintenances ───────────────────────────────────────
        $maintenances         = Maintenance::count();
        $maintenances_encours = Maintenance::where('statut', 'en_cours')->count();
        $maintenances_planif  = Maintenance::where('statut', 'planifiee')
                                           ->orWhere('statut', 'planifié')
                                           ->count();
        $maintenance_cout_total = Maintenance::sum('cout');

        // ── Documents ──────────────────────────────────────────
        $documents      = Document::count();
        $docs_expire    = Document::where('date_expiration', '<', Carbon::now())->count();
        $docs_bientot   = Document::whereBetween('date_expiration', [
            Carbon::now(),
            Carbon::now()->addDays(30),
        ])->count();

        // ── Alertes (docs expirant dans 7 jours) ───────────────
        $alertes = Document::where('date_expiration', '<=', Carbon::now()->addDays(7))->count();

        // ── Recettes ───────────────────────────────────────────
        $recettes       = RecetteMensuelle::whereMonth('date', now()->month)
                                          ->whereYear('date', now()->year)
                                          ->sum('montant');
        $recettes_total = RecetteMensuelle::sum('montant');
        $recettes_mois_prec = RecetteMensuelle::whereMonth('date', now()->subMonth()->month)
                                               ->whereYear('date', now()->subMonth()->year)
                                               ->sum('montant');

        // Évolution recette en % vs mois précédent
        $recettes_evolution = $recettes_mois_prec > 0
            ? round((($recettes - $recettes_mois_prec) / $recettes_mois_prec) * 100, 1)
            : 0;

        // Barre de progression recette (par rapport au maximum mensuel connu)
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

        // ── Vue selon le rôle ──────────────────────────────────
        $view = view()->exists("{$role}.index") ? "{$role}.index" : 'admin.dashboard';

        return view($view, compact(
            'role',
            // Véhicules
            'vehicules',
            'vehicules_disponibles',
            'vehicules_mission',
            'vehicules_maintenance',
            // Chauffeurs
            'chauffeurs',
            // Voyages
            'voyages',
            'voyages_mois',
            'voyages_today',
            // Maintenances
            'maintenances',
            'maintenances_encours',
            'maintenances_planif',
            'maintenance_cout_total',
            // Documents
            'documents',
            'docs_expire',
            'docs_bientot',
            'alertes',
            // Recettes
            'recettes',
            'recettes_total',
            'recettes_evolution',
            'recettes_pct',
            // Users
            'users',
            // Taux
            'occupation'
        ));
    }
}
