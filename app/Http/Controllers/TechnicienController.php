<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Requests\MaintenanceRequest;

class TechnicienController extends Controller
{
    // ─────────────────────────────────────────
    //  DASHBOARD
    // ─────────────────────────────────────────
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

    // ─────────────────────────────────────────
    //  VEHICULES — READ-ONLY POUR LE TECHNICIEN
    // ─────────────────────────────────────────
    public function vehiculesIndex()
    {
        $vehicules = Vehicule::orderBy('immatriculation')->paginate(12);
        return view('technicien.vehicules.index', compact('vehicules'));
    }

    public function vehiculesShow(Vehicule $vehicule)
    {
        $vehicule->load(['maintenances' => function($q) {
            $q->orderByDesc('date_prevue');
        }]);
        return view('technicien.vehicules.show', compact('vehicule'));
    }

    // ─────────────────────────────────────────
    //  MAINTENANCES — CRUD COMPLET
    // ─────────────────────────────────────────
    public function maintenancesIndex()
    {
        $maintenances = Maintenance::with('vehicule')->orderByDesc('date_prevue')->paginate(15);
        return view('technicien.maintenances.index', compact('maintenances'));
    }

    public function maintenancesCreate()
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        return view('technicien.maintenances.create', compact('vehicules'));
    }

    public function maintenancesStore(MaintenanceRequest $request)
    {
        Maintenance::create($request->validated());

        return redirect()->route('technicien.maintenances.index')
                         ->with('success', 'Maintenance ajoutée avec succès.');
    }

    public function maintenancesShow(Maintenance $maintenance)
    {
        $maintenance->load('vehicule');
        return view('technicien.maintenances.show', compact('maintenance'));
    }

    public function maintenancesEdit(Maintenance $maintenance)
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        return view('technicien.maintenances.edit', compact('maintenance', 'vehicules'));
    }

    public function maintenancesUpdate(MaintenanceRequest $request, Maintenance $maintenance)
    {
        $maintenance->update($request->validated());

        return redirect()->route('technicien.maintenances.index')
                         ->with('success', 'Maintenance mise à jour avec succès.');
    }

    public function maintenancesDestroy(Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('technicien.maintenances.index')
                         ->with('success', 'Maintenance supprimée avec succès.');
    }
}
