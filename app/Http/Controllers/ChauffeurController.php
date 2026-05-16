<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = request('search');
        $chauffeurs = Chauffeur::when($search, function($q) use ($search) {
            return $q->where(function($q2) use ($search) {
                $q2->where('nom', 'like', "%{$search}%")
                   ->orWhere('prenom', 'like', "%{$search}%")
                   ->orWhere('permis', 'like', "%{$search}%")
                ;
            });
        })->latest()->paginate(12)->appends(request()->query());

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        // Dynamic view resolution
        $view = "{$role}.chauffeurs.index";
        if ($role === 'admin') $view = 'admin.chauffeur.index';
        if (!view()->exists($view)) $view = 'admin.chauffeur.index';

        return view($view, compact('chauffeurs', 'rolePrefix'));
    }

    public function show(Chauffeur $chauffeur)
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.chauffeurs.show";
        if ($role === 'admin') $view = 'admin.chauffeur.show';
        if (!view()->exists($view)) $view = 'admin.chauffeur.show';
        
        return view($view, compact('chauffeur', 'rolePrefix'));
    }

    public function create()
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.chauffeurs.create";
        if ($role === 'admin') $view = 'admin.chauffeur.create';
        if (!view()->exists($view)) $view = 'admin.chauffeur.create';
        
        $rolePrefix = $role;
        return view($view, compact('rolePrefix'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z\s\-]+$/'],
            'prenom' => ['required', 'string', 'regex:/^[a-zA-Z\s\-]+$/'],
            'telephone' => ['required', 'regex:/^(05|06)[0-9]{7}$/'],
            'permis' => ['required', 'unique:chauffeurs'],
            'contact' => 'nullable',
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ], [
            'nom.regex' => 'Le nom ne doit contenir que des lettres.',
            'prenom.regex' => 'Le prénom ne doit contenir que des lettres.',
            'telephone.regex' => 'Le numéro doit commencer par 05 ou 06 et contenir exactement 9 chiffres.',
        ]);

        $data = $request->except('photo');
        $data['nom'] = strtoupper($data['nom']);
        $data['prenom'] = ucfirst(strtolower($data['prenom']));
        $data['actif'] = (int) $data['actif'];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('chauffeurs', 'public');
        }

        Chauffeur::create($data);

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.chauffeurs.index')->with('success','Chauffeur ajouté avec succès');
    }

    public function edit($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.chauffeurs.edit";
        if ($role === 'admin') $view = 'admin.chauffeur.edit';
        if (!view()->exists($view)) $view = 'admin.chauffeur.edit';
        
        $rolePrefix = $role;
        return view($view, compact('chauffeur', 'rolePrefix'));
    }

    public function update(Request $request, $id)
    {
        $chauffeur = Chauffeur::findOrFail($id);

        $request->validate([
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z\s\-]+$/'],
            'prenom' => ['required', 'string', 'regex:/^[a-zA-Z\s\-]+$/'],
            'telephone' => ['required', 'regex:/^(05|06)[0-9]{7}$/'],
            'permis' => ['required', 'unique:chauffeurs,permis,' . $id],
            'contact' => 'nullable',
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ], [
            'nom.regex' => 'Le nom ne doit contenir que des lettres.',
            'prenom.regex' => 'Le prénom ne doit contenir que des lettres.',
            'telephone.regex' => 'Le numéro doit commencer par 05 ou 06 et contenir exactement 9 chiffres.',
        ]);

        $data = $request->except('photo');
        $data['nom'] = strtoupper($data['nom']);
        $data['prenom'] = ucfirst(strtolower($data['prenom']));
        $data['actif'] = (int) $data['actif'];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('chauffeurs', 'public');
        }

        $chauffeur->update($data);

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.chauffeurs.index')->with('success','Modifié avec succès');
    }

    public function destroy($id)
    {
        Chauffeur::destroy($id);
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()->route($role . '.chauffeurs.index')->with('success','Supprimé avec succès');
    }
}

