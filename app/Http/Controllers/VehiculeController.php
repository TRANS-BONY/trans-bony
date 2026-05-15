<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicule::query();

        if ($request->search) {
            $query->where('immatriculation', 'like', "%{$request->search}%")
                  ->orWhere('marque', 'like', "%{$request->search}%")
                  ->orWhere('modele', 'like', "%{$request->search}%");
        }

        $vehicules = $query->latest()->paginate(12)->appends($request->query());

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.vehicules.index";
        if ($role === 'admin') $view = 'admin.vehicule.index';
        if (!view()->exists($view)) $view = 'admin.vehicule.index';

        return view($view, compact('vehicules', 'rolePrefix'));
    }

    public function show(Vehicule $vehicule)
    {
        $vehicule->loadCount(['voyages', 'maintenances']);

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.vehicules.show";
        if ($role === 'admin') $view = 'admin.vehicule.show';
        if (!view()->exists($view)) $view = 'admin.vehicule.show';

        return view($view, compact('vehicule', 'rolePrefix'));
    }

    public function create()
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.vehicules.create";
        if ($role === 'admin') $view = 'admin.vehicule.create';
        if (!view()->exists($view)) $view = 'admin.vehicule.create';
        
        return view($view, compact('rolePrefix'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'immatriculation' => ['required', 'unique:vehicules', 'regex:/^\d{3} [A-Z]{2} \d{1}$/'],
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'required|integer|between:1950,2026',
            'capacite' => 'required|integer|between:1,100',
            'statut' => 'required|in:disponible,maintenance,mission'
        ], [
            'immatriculation.regex' => 'Le format de l\'immatriculation doit être : 001 XP 4 (3 chiffres, 2 lettres, 1 chiffre).'
        ]);

        $data['immatriculation'] = strtoupper($data['immatriculation']);
        $vehicule = Vehicule::create($data);

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.vehicules.index')->with('success', 'Véhicule ajouté avec succès!');
    }

    public function edit(Vehicule $vehicule)
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.vehicules.edit";
        if ($role === 'admin') $view = 'admin.vehicule.edit';
        if (!view()->exists($view)) $view = 'admin.vehicule.edit';
        
        return view($view, compact('vehicule', 'rolePrefix'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $data = $request->validate([
            'immatriculation' => ['required', 'unique:vehicules,immatriculation,' . $vehicule->id, 'regex:/^\d{3} [A-Z]{2} \d{1}$/'],
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'required|integer|between:1950,2026',
            'capacite' => 'required|integer|between:0,100',
            'statut' => 'required|in:disponible,maintenance,mission'
        ], [
            'immatriculation.regex' => 'Le format de l\'immatriculation doit être : 001 XP 4 (3 chiffres, 2 lettres, 1 chiffre).'
        ]);

        $data['immatriculation'] = strtoupper($data['immatriculation']);
        $vehicule->update($data);

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.vehicules.index')->with('success', 'Véhicule modifié avec succès.');
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();

        return back()->with('success', 'Véhicule supprimé.');
    }
}

