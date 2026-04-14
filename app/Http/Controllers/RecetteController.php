<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecetteRequest;
use App\Http\Requests\UpdateRecetteRequest;
use App\Models\RecetteMensuelle;
use App\Models\Vehicule;
use App\Models\Voyage;

class RecetteController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::count();
        $voyages = Voyage::count();
        $recettes = RecetteMensuelle::orderBy('date', 'desc')->paginate(10);
        return view('admin.finances.index', compact('vehicules', 'voyages', 'recettes'));
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

