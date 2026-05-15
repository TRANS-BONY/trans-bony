<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class TechnicienController extends Controller
{
    /**
     * Dashboard Technicien
     */
    public function dashboard()
    {
        $nb_vehicules = Vehicule::count();
        $nb_maintenances = Maintenance::count();
        
        // Maintenances par statut
        $maintenances_en_cours = Maintenance::where('statut', 'en cours')->count();
        $maintenances_terminees = Maintenance::where('statut', 'terminee')->count();
        $maintenances_planifiees = Maintenance::where('statut', 'planifiee')->count();
        
        $dernieres_maintenances = Maintenance::with('vehicule')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('technicien.dashboard', compact(
            'nb_vehicules',
            'nb_maintenances',
            'maintenances_en_cours',
            'maintenances_terminees',
            'maintenances_planifiees',
            'dernieres_maintenances'
        ));
    }
}
