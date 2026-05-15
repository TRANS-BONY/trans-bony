<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use App\Models\Document;
use App\Models\Vehicule;
use App\Models\Maintenance;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GestionnaireController extends Controller
{
    /**
     * Dashboard Gestionnaire
     */
    public function dashboard()
    {
        $stats = [
            'vehicules' => Vehicule::count(),
            'chauffeurs' => Chauffeur::count(),
            'documents' => Document::count(),
            'documents_expirant' => Document::where('date_expiration', '<=', now()->addDays(30))->count(),
            'maintenances_en_cours' => Maintenance::where('statut', 'en cours')->count(),
        ];

        $derniers_vehicules = Vehicule::latest()->take(5)->get();
        $derniers_chauffeurs = Chauffeur::latest()->take(5)->get();

        return view('gestionnaire.dashboard', compact('stats', 'derniers_vehicules', 'derniers_chauffeurs'));
    }
}
