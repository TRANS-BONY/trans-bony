<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->search;
        $statut = $request->statut;

        $query = Chauffeur::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('permis', 'like', "%{$search}%");
            });
        }

        if ($statut !== null && $statut !== '') {
            $query->where('actif', $statut);
        }

        $chauffeurs = $query->latest()->paginate(12)->appends($request->query());

        $stats = [
            'total' => Chauffeur::count(),
            'actifs' => Chauffeur::where('actif', 1)->count(),
            'inactifs' => Chauffeur::where('actif', 0)->count(),
        ];

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        // Dynamic view resolution
        $view = "{$role}.chauffeurs.index";
        if ($role === 'admin') $view = 'admin.chauffeur.index';
        if (!view()->exists($view)) $view = 'admin.chauffeur.index';

        return view($view, compact('chauffeurs', 'rolePrefix', 'stats'));
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
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z\sÇç\-]+$/u'],
            'prenom' => ['required', 'string', 'regex:/^[a-zA-ZÇç][a-zA-Z\sÇç\-]*$/u'],
            'telephone' => ['required', 'regex:/^(04|05|06)[0-9]{7}$/'],
            'permis' => ['required', 'unique:chauffeurs', 'regex:/^CG-\d{6}-[A-Z]{3}-[A-Z0-9]{4}$/'],
            'contact' => ['required', 'regex:/^(04|05|06)[0-9]{7}$/'],
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ], [
            'nom.regex' => 'Le nom ne doit contenir que des lettres, des espaces ou des tirets.',
            'prenom.regex' => 'Le prénom doit commencer par une lettre et ne contenir que des lettres, ç, espaces ou tirets.',
            'telephone.regex' => 'Le numéro doit commencer par 04, 05 ou 06 et contenir exactement 9 chiffres.',
            'permis.regex' => 'Le format du permis doit être : CG-123456-ABC-202H',
            'contact.required' => 'Le contact d\'urgence est obligatoire.',
            'contact.regex' => 'Le numéro d\'urgence doit commencer par 04, 05 ou 06 et contenir exactement 9 chiffres.',
        ]);

        $data = $request->except('photo');
        $data['nom'] = mb_strtoupper($data['nom'], 'UTF-8');
        $data['prenom'] = mb_convert_case($data['prenom'], MB_CASE_TITLE, 'UTF-8');
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
            'nom' => ['required', 'string', 'regex:/^[a-zA-Z\sÇç\-]+$/u'],
            'prenom' => ['required', 'string', 'regex:/^[a-zA-ZÇç][a-zA-Z\sÇç\-]*$/u'],
            'telephone' => ['required', 'regex:/^(04|05|06)[0-9]{7}$/'],
            'permis' => ['required', 'unique:chauffeurs,permis,' . $id, 'regex:/^CG-\d{6}-[A-Z]{3}-[A-Z0-9]{4}$/'],
            'contact' => ['required', 'regex:/^(04|05|06)[0-9]{7}$/'],
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ], [
            'nom.regex' => 'Le nom ne doit contenir que des lettres, des espaces ou des tirets.',
            'prenom.regex' => 'Le prénom doit commencer par une lettre et ne contenir que des lettres, ç, espaces ou tirets.',
            'telephone.regex' => 'Le numéro doit commencer par 04, 05 ou 06 et contenir exactement 9 chiffres.',
            'permis.regex' => 'Le format du permis doit être : CG-123456-ABC-202H',
            'contact.required' => 'Le contact d\'urgence est obligatoire.',
            'contact.regex' => 'Le numéro d\'urgence doit commencer par 04, 05 ou 06 et contenir exactement 9 chiffres.',
        ]);

        $data = $request->except('photo');
        $data['nom'] = mb_strtoupper($data['nom'], 'UTF-8');
        $data['prenom'] = mb_convert_case($data['prenom'], MB_CASE_TITLE, 'UTF-8');
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

