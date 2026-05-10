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
                ;
            });
        })->with('vehicule')->orderByDesc('date')->paginate(15)->appends(request()->query());

        // Agrégats globaux (sur toute la table, pas seulement la page courante)
        $recettes_total      = RecetteMensuelle::sum('montant');
        $recettes_mois_total = RecetteMensuelle::whereMonth('date', now()->month)
                                                ->whereYear('date', now()->year)
                                                ->sum('montant');
        $recettes_avg        = RecetteMensuelle::avg('montant') ?? 0;
        $recettes_count      = RecetteMensuelle::count();

        return view('admin.finances.index', compact(
            'recettes',
            'recettes_total',
            'recettes_mois_total',
            'recettes_avg',
            'recettes_count'
        ));
    }

    public function create()
    {
        $vehicules = \App\Models\Vehicule::all();
        return view('admin.finances.create', compact('vehicules'));
    }

    public function store(StoreRecetteRequest $request)
    {
        RecetteMensuelle::create($request->validated());
        return redirect()->route('admin.recettes.index')->with('success', 'Recette créée avec succès.');
    }

    public function show(RecetteMensuelle $recette)
    {
        $recette->load('vehicule.voyages', 'vehicule.maintenances', 'vehicule.documents');
        return view('admin.finances.show', compact('recette'));
    }

    public function edit(RecetteMensuelle $recette)
    {
        $vehicules = \App\Models\Vehicule::all();
        return view('admin.finances.edit', compact('recette', 'vehicules'));
    }

    public function update(UpdateRecetteRequest $request, RecetteMensuelle $recette)
    {
        $recette->update($request->validated());
        return redirect()->route('admin.recettes.index')->with('success', 'Recette modifiée avec succès.');
    }

    public function destroy(RecetteMensuelle $recette)
    {
        $recette->delete();
        return redirect()->route('admin.recettes.index')->with('success', 'Recette supprimée avec succès.');
    }
}

