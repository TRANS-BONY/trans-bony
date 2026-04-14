<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{
    public function index()
    {
        $chauffeurs = Chauffeur::latest()->get();
        return view('admin.chauffeur.index', compact('chauffeurs'));
    }

    public function show(Chauffeur $chauffeur)
    {
        return view('admin.chauffeur.show', compact('chauffeur'));
    }

    public function create()
    {
        return view('admin.chauffeur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'permis' => 'required|unique:chauffeurs',
            'telephone' => 'nullable',
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ]);

        $data['nom'] = strtoupper($data['nom']);
        $data['prenom'] = ucfirst(strtolower($data['prenom']));
        $data['actif'] = (int) $data['actif'];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('chauffeurs', 'public');
        }

        Chauffeur::create($data);

        return redirect()->route('admin.chauffeurs.index')
            ->with('success','Chauffeur ajouté avec succès');
    }

    public function edit($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);
        return view('admin.chauffeur.edit', compact('chauffeur'));
    }

    public function update(Request $request, $id)
    {
        $chauffeur = Chauffeur::findOrFail($id);

        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'permis' => 'required|unique:chauffeurs,permis,' . $id,
            'telephone' => 'nullable',
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ]);

        $data['nom'] = strtoupper($data['nom']);
        $data['prenom'] = ucfirst(strtolower($data['prenom']));
        $data['actif'] = (int) $data['actif'];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('chauffeurs', 'public');
        }

        $chauffeur->update($data);

        return redirect()->route('admin.chauffeurs.index')
            ->with('success','Modifié avec succès');
    }

    public function destroy($id)
    {
        Chauffeur::destroy($id);

        return redirect()->route('admin.chauffeurs.index')
            ->with('success','Supprimé avec succès');
    }
}

