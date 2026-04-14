<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Vehicule::class);

        $query = Vehicule::query();

        if ($request->search) {
            $query->where('immatriculation', 'like', "%{$request->search}%")
                  ->orWhere('marque', 'like', "%{$request->search}%")
                  ->orWhere('modele', 'like', "%{$request->search}%");
        }

        $vehicules = $query->latest()->get();

        return view('admin.vehicule.index', compact('vehicules'));
    }

    public function show(Vehicule $vehicule)
    {
        $this->authorize('view', $vehicule);

        $vehicule->loadCount(['voyages', 'maintenances']);

        return view('admin.vehicule.show', compact('vehicule'));
    }

    public function create()
    {
        $this->authorize('create', Vehicule::class);
        return view('admin.vehicule.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'immatriculation' => [
                'required',
                'unique:vehicules',
                'regex:/^[A-Za-z0-9-]+$/'
            ],
            'marque' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'modele' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'annee' => 'required|integer|between:1950,2026',
            'capacite' => 'required|integer|between:0,52',
            'statut' => 'required|in:disponible,maintenance,mission'
        ]);

        $this->authorize('create', Vehicule::class);

        $data['immatriculation'] = strtoupper($data['immatriculation']);
        $data['marque'] = strtoupper($data['marque']);
        $data['modele'] = strtoupper($data['modele']);

        $vehicule = Vehicule::create($data);

        return redirect()->route('admin.vehicules.show', $vehicule)
            ->with('success', 'Véhicule ajouté avec succès!');
    }

    public function edit(Vehicule $vehicule)
    {
        $this->authorize('view', $vehicule);
        return view('admin.vehicule.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $this->authorize('update', $vehicule);

        $data = $request->validate([
            'immatriculation' => [
                'required',
                'regex:/^[A-Za-z0-9-]+$/',
                'unique:vehicules,immatriculation,' . $vehicule->id
            ],
            'marque' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'modele' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'annee' => 'required|integer|between:1950,2026',
            'capacite' => 'required|integer|between:0,52',
            'statut' => 'required|in:disponible,maintenance,mission'
        ]);

        $data['immatriculation'] = strtoupper($data['immatriculation']);
        $data['marque'] = strtoupper($data['marque']);
        $data['modele'] = strtoupper($data['modele']);

        $vehicule->update($data);

        return redirect()->route('admin.vehicules.index')
            ->with('success', 'Véhicule modifié avec succès.');
    }

    public function destroy(Vehicule $vehicule)
    {
        $this->authorize('delete', $vehicule);

        $vehicule->delete();

        return back()->with('success', 'Véhicule supprimé.');
    }
}

