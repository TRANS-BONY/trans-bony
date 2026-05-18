<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecetteRequest;
use App\Http\Requests\UpdateRecetteRequest;
use App\Models\RecetteMensuelle;
use App\Models\Vehicule;
use App\Models\Voyage;

class RecetteController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = request('search');
        $recettes = RecetteMensuelle::when($search, function($q) use ($search) {
            return $q->where(function($q2) use ($search) {
                $q2->where('montant', 'like', "%{$search}%")
                   ->orWhere('type', 'like', "%{$search}%")
                   ->orWhere('date', 'like', "%{$search}%")
                   ->orWhereHas('vehicule', function($q3) use ($search) {
                       $q3->where('immatriculation', 'like', "%{$search}%")
                          ->orWhere('marque', 'like', "%{$search}%")
                          ->orWhere('modele', 'like', "%{$search}%");
                   });
            });
        })->with('vehicule')->orderByDesc('date')->paginate(15)->appends(request()->query());

        // Agrégats globaux
        $recettes_total      = RecetteMensuelle::sum('montant');
        $recettes_mois_total = RecetteMensuelle::whereMonth('date', now()->month)
                                                ->whereYear('date', now()->year)
                                                ->sum('montant');
        $recettes_avg        = RecetteMensuelle::avg('montant') ?? 0;
        $recettes_count      = RecetteMensuelle::count();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;

        $view = "{$role}.recettes.index";
        if ($role === 'admin') $view = 'admin.finances.index';
        if (!view()->exists($view)) $view = 'admin.finances.index';

        return view($view, compact(
            'recettes',
            'recettes_total',
            'recettes_mois_total',
            'recettes_avg',
            'recettes_count',
            'rolePrefix'
        ));
    }

    public function create()
    {
        $vehicules = \App\Models\Vehicule::all();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.recettes.create";
        if ($role === 'admin') $view = 'admin.finances.create';
        if (!view()->exists($view)) $view = 'admin.finances.create';
        
        return view($view, compact('vehicules'));
    }

    public function store(StoreRecetteRequest $request)
    {
        RecetteMensuelle::create($request->validated());
        
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.recettes.index')->with('success', 'Recette créée avec succès.');
    }

    public function show(RecetteMensuelle $recette)
    {
        $recette->load('vehicule.voyages', 'vehicule.maintenances', 'vehicule.documents');
        
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.recettes.show";
        if ($role === 'admin') $view = 'admin.finances.show';
        if (!view()->exists($view)) $view = 'admin.finances.show';
        
        return view($view, compact('recette', 'rolePrefix'));
    }

    public function edit(RecetteMensuelle $recette)
    {
        $vehicules = \App\Models\Vehicule::all();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.recettes.edit";
        if ($role === 'admin') $view = 'admin.finances.edit';
        if (!view()->exists($view)) $view = 'admin.finances.edit';
        
        return view($view, compact('recette', 'vehicules'));
    }

    public function update(UpdateRecetteRequest $request, RecetteMensuelle $recette)
    {
        $recette->update($request->validated());
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.recettes.index')->with('success', 'Recette modifiée avec succès.');
    }

    public function destroy(RecetteMensuelle $recette)
    {
        $recette->delete();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.recettes.index')->with('success', 'Recette supprimée avec succès.');
    }
}

