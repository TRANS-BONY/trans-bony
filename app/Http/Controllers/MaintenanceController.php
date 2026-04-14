<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Vehicule;
use Illuminate\Http\Request;
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

        $maintenances = $query->paginate(15)->appends($request->query());
return view('admin.maintenance.index', compact('maintenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required',
            'date_prevue' => 'required|date',
            'cout' => 'required|numeric'
        ]);

        try {
            Maintenance::create(array_merge($request->only([
                'vehicule_id','type','date_prevue','cout'
            ]), ['statut' => 'planifiee']));
            return redirect()->route('admin.maintenances.index')->with('success','Maintenance enregistrée');
        } catch (\Exception $e) {
            Log::error('Maintenance create failed: ' . $e->getMessage());
            return back()->with('error','Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $this->authorize('create', Maintenance::class);
        $vehicules = Vehicule::all();
        if ($vehicules->isEmpty()) {
            session()->flash('warning', 'Aucun véhicule disponible. Créer d\'abord des véhicules.');
        }
        return view('admin.maintenance.create', compact('vehicules'));
    }

    public function show(Maintenance $maintenance)
    {
        $this->authorize('view', $maintenance);
        $maintenance->load('vehicule');
        return view('admin.maintenance.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $this->authorize('update', $maintenance);
        $vehicules = Vehicule::all();
        return view('admin.maintenance.edit', compact('maintenance','vehicules'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required',
            'date_prevue' => 'required|date',
            'cout' => 'required|numeric'
        ]);

        $maintenance->update(array_merge($request->only(['vehicule_id', 'type', 'date_prevue', 'cout']), ['statut' => $maintenance->statut]));

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance mise à jour');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance supprimée');
    }
}

