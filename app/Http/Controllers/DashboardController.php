<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Models\RecetteMensuelle;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $role = strtolower($roles->first() ?? 'agent');

        // Data par rôle
        $vehicules = 0;
        $chauffeurs = 0;
        $voyages = 0;
        $documents = 0;
        $maintenances = 0;
        $recettes = RecetteMensuelle::sum('montant') ?? 0;
        $alertes = Document::where('date_expiration', '<=', Carbon::now()->addDays(7))->count();

        if (in_array($role, ['admin', 'gestionnaire', 'manager'])) {
            $vehicules = Vehicule::count();
            $chauffeurs = Chauffeur::count();
            $voyages = Voyage::count();
            $documents = Document::count();
        } elseif ($role === 'agent') {
            $voyages = 3; // Placeholder - update with personal filter when relations defined
        } elseif ($role === 'technicien') {
            $maintenances = Maintenance::count();
        } // comptable uses $recettes

        // Fallback for unknown roles
        $view = view()->exists("{$role}.index") ? "{$role}.index" : 'agent.index';

        return view($view, compact(
            'role',
            'vehicules',
            'chauffeurs',
            'voyages',
            'documents',
            'maintenances',
            'recettes',
            'alertes'
        ));
    }
}

