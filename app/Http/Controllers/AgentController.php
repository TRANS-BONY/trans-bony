<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Dashboard Agent
     */
    public function dashboard()
    {
        $vehicules = Vehicule::count();
        $chauffeurs = Chauffeur::count();
        $voyages = Voyage::count();
        
        return view('agent.index', compact('vehicules', 'chauffeurs', 'voyages'));
    }
}
