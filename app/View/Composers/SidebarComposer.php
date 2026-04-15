<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Models\RecetteMensuelle;
use App\Models\User;
use Carbon\Carbon;

class SidebarComposer
{
    /**
     * Injecte les compteurs en temps réel dans toutes les vues utilisant le layout app.
     */
    public function compose(View $view): void
    {
        // Only run for authenticated users. Guest pages (login, register…) are skipped.
        if (! Auth::check()) {
            return;
        }

        try {

        // ── Véhicules ──────────────────────────────────────────
        $sidebar_vehicules       = Vehicule::count();
        $sidebar_vehicules_dispo = Vehicule::where('statut', 'disponible')->count();
        $sidebar_vehicules_maint = Vehicule::where('statut', 'maintenance')->count();
        $sidebar_vehicules_miss  = Vehicule::where('statut', 'mission')->count();

        // ── Chauffeurs ─────────────────────────────────────────
        $sidebar_chauffeurs = Chauffeur::count();

        // ── Voyages ────────────────────────────────────────────
        $sidebar_voyages         = Voyage::count();
        $sidebar_voyages_today   = Voyage::whereDate('date_depart', today())->count();
        $sidebar_voyages_month   = Voyage::whereMonth('date_depart', now()->month)
                                         ->whereYear('date_depart', now()->year)
                                         ->count();

        // ── Maintenances ───────────────────────────────────────
        $sidebar_maintenances         = Maintenance::count();
        $sidebar_maintenances_encours = Maintenance::where('statut', 'en_cours')->count();
        $sidebar_maintenances_planif  = Maintenance::where('statut', 'planifiee')
                                                    ->orWhere('statut', 'planifié')
                                                    ->count();

        // ── Documents ──────────────────────────────────────────
        $sidebar_documents       = Document::count();
        $sidebar_docs_expire     = Document::where('date_expiration', '<', Carbon::now())->count();
        $sidebar_docs_bientot    = Document::whereBetween('date_expiration', [
            Carbon::now(),
            Carbon::now()->addDays(30),
        ])->count();
        // Badge urgent = expirés + bientôt expirés
        $sidebar_docs_alerte     = $sidebar_docs_expire + $sidebar_docs_bientot;

        // ── Recettes ───────────────────────────────────────────
        $sidebar_recettes        = RecetteMensuelle::count();
        $sidebar_recettes_total  = RecetteMensuelle::sum('montant');
        $sidebar_recettes_mois   = RecetteMensuelle::whereMonth('date', now()->month)
                                                    ->whereYear('date', now()->year)
                                                    ->sum('montant');

        // ── Utilisateurs ───────────────────────────────────────
        $sidebar_users = User::count();

        // ── Alertes globales (badge sidebar Documents) ─────────
        $sidebar_alertes = Document::where('date_expiration', '<=', Carbon::now()->addDays(7))->count();

            $view->with(compact(
                'sidebar_vehicules',
                'sidebar_vehicules_dispo',
                'sidebar_vehicules_maint',
                'sidebar_vehicules_miss',
                'sidebar_chauffeurs',
                'sidebar_voyages',
                'sidebar_voyages_today',
                'sidebar_voyages_month',
                'sidebar_maintenances',
                'sidebar_maintenances_encours',
                'sidebar_maintenances_planif',
                'sidebar_documents',
                'sidebar_docs_expire',
                'sidebar_docs_bientot',
                'sidebar_docs_alerte',
                'sidebar_recettes',
                'sidebar_recettes_total',
                'sidebar_recettes_mois',
                'sidebar_users',
                'sidebar_alertes'
            ));
        } catch (\Throwable $e) {
            // Si la DB est inaccessible (ex: migrations pas encore faites),
            // on injecte des valeurs à zéro pour ne pas bloquer la page.
            $view->with([
                'sidebar_vehicules'           => 0,
                'sidebar_vehicules_dispo'     => 0,
                'sidebar_vehicules_maint'     => 0,
                'sidebar_vehicules_miss'      => 0,
                'sidebar_chauffeurs'          => 0,
                'sidebar_voyages'             => 0,
                'sidebar_voyages_today'       => 0,
                'sidebar_voyages_month'       => 0,
                'sidebar_maintenances'        => 0,
                'sidebar_maintenances_encours'=> 0,
                'sidebar_maintenances_planif' => 0,
                'sidebar_documents'           => 0,
                'sidebar_docs_expire'         => 0,
                'sidebar_docs_bientot'        => 0,
                'sidebar_docs_alerte'         => 0,
                'sidebar_recettes'            => 0,
                'sidebar_recettes_total'      => 0,
                'sidebar_recettes_mois'       => 0,
                'sidebar_users'               => 0,
                'sidebar_alertes'             => 0,
            ]);
        }
    }
}
