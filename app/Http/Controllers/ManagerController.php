<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Models\RecetteMensuelle;
use App\Models\Rapport;

class ManagerController extends Controller
{
    /**
     * Dashboard Manager
     */
    public function dashboard()
    {
        $stats = [
            'vehicules'         => Vehicule::count(),
            'chauffeurs'        => Chauffeur::count(),
            'voyages'           => Voyage::count(),
            'voyages_en_cours'  => Voyage::where('type', 'voyage')->count(),
            'maintenances'      => Maintenance::count(),
            'recettes_total'    => RecetteMensuelle::sum('montant'),
        ];

        $derniers_voyages        = Voyage::with(['vehicule', 'chauffeur'])->latest('created_at')->take(5)->get();
        $dernieres_maintenances  = Maintenance::with('vehicule')->latest('created_at')->take(5)->get();

        return view('manager.dashboard', compact('stats', 'derniers_voyages', 'dernieres_maintenances'));
    }
}
