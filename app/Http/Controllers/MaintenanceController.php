<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use App\Http\Requests\MaintenanceRequest;
use Illuminate\Support\Facades\Log;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with('vehicule');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('type', 'like', '%'.$request->search.'%')
                  ->orWhereHas('vehicule', function($sub) use ($request) {
                      $sub->where('immatriculation', 'like', '%'.$request->search.'%')
                          ->orWhere('marque', 'like', '%'.$request->search.'%');
                  });
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $maintenances = $query->latest()->paginate(10)->appends($request->query());

        $stats = [
            'total' => Maintenance::count(),
            'en_cours' => Maintenance::where('statut', 'en_cours')->count(),
            'termine' => Maintenance::where('statut', 'termine')->count(),
            'annule' => Maintenance::where('statut', 'annule')->count(),
        ];

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.maintenances.index";
        if ($role === 'admin') $view = 'admin.maintenance.index';
        if (!view()->exists($view)) $view = 'admin.maintenance.index';

        return view($view, compact('maintenances', 'rolePrefix', 'stats'));
    }

    public function store(MaintenanceRequest $request)
    {
        try {
            Maintenance::create($request->validated());
            $role = auth()->user()->getRoleNames()->first() ?: 'admin';
            return redirect()->route($role . '.maintenances.index')->with('success','Maintenance enregistrée');
        } catch (\Exception $e) {
            Log::error('Maintenance create failed: ' . $e->getMessage());
            return back()->with('error','Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $vehicules = Vehicule::all();
        if ($vehicules->isEmpty()) {
            session()->flash('warning', 'Aucun véhicule disponible. Créer d\'abord des véhicules.');
        }
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.maintenances.create";
        if ($role === 'admin') $view = 'admin.maintenance.create';
        if (!view()->exists($view)) $view = 'admin.maintenance.create';
        
        return view($view, compact('vehicules'));
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('vehicule');
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.maintenances.show";
        if ($role === 'admin') $view = 'admin.maintenance.show';
        if (!view()->exists($view)) $view = 'admin.maintenance.show';
        
        return view($view, compact('maintenance', 'rolePrefix'));
    }

    public function edit(Maintenance $maintenance)
    {
        $vehicules = Vehicule::all();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.maintenances.edit";
        if ($role === 'admin') $view = 'admin.maintenance.edit';
        if (!view()->exists($view)) $view = 'admin.maintenance.edit';
        
        return view($view, compact('maintenance','vehicules'));
    }

    public function update(MaintenanceRequest $request, Maintenance $maintenance)
    {
        $maintenance->update($request->validated());
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.maintenances.index')->with('success', 'Maintenance mise à jour');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.maintenances.index')->with('success', 'Maintenance supprimée');
    }
}

