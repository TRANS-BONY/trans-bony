<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use App\Models\Document;
use App\Models\Vehicule;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GestionnaireController extends Controller
{
    // ─────────────────────────────────────────
    //  DASHBOARD
    // ─────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'vehicules' => Vehicule::count(),
            'chauffeurs' => Chauffeur::count(),
            'documents' => Document::count(),
            'documents_expirant' => Document::where('date_expiration', '<=', now()->addDays(30))->count(),
            'maintenances_en_cours' => Maintenance::where('statut', 'en cours')->count(),
        ];

        $derniers_vehicules = Vehicule::latest()->take(5)->get();
        $derniers_chauffeurs = Chauffeur::latest()->take(5)->get();

        return view('gestionnaire.dashboard', compact('stats', 'derniers_vehicules', 'derniers_chauffeurs'));
    }

    // ─────────────────────────────────────────
    //  CHAUFFEURS (CRUD)
    // ─────────────────────────────────────────
    public function chauffeursIndex()
    {
        $chauffeurs = Chauffeur::latest()->paginate(10);
        return view('gestionnaire.chauffeurs.index', compact('chauffeurs'));
    }

    public function chauffeursCreate()
    {
        return view('gestionnaire.chauffeurs.create');
    }

    public function chauffeursStore(Request $request)
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

        return redirect()->route('gestionnaire.chauffeurs.index')->with('success','Chauffeur ajouté avec succès');
    }

    public function chauffeursShow(Chauffeur $chauffeur)
    {
        return view('gestionnaire.chauffeurs.show', compact('chauffeur'));
    }

    public function chauffeursEdit(Chauffeur $chauffeur)
    {
        return view('gestionnaire.chauffeurs.edit', compact('chauffeur'));
    }

    public function chauffeursUpdate(Request $request, Chauffeur $chauffeur)
    {
        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'permis' => 'required|unique:chauffeurs,permis,' . $chauffeur->id,
            'telephone' => 'nullable',
            'actif' => 'required|in:0,1',
            'photo' => 'nullable|image'
        ]);

        $data['nom'] = strtoupper($data['nom']);
        $data['prenom'] = ucfirst(strtolower($data['prenom']));
        $data['actif'] = (int) $data['actif'];

        if ($request->hasFile('photo')) {
            if ($chauffeur->photo) Storage::disk('public')->delete($chauffeur->photo);
            $data['photo'] = $request->file('photo')->store('chauffeurs', 'public');
        }

        $chauffeur->update($data);

        return redirect()->route('gestionnaire.chauffeurs.index')->with('success','Modifié avec succès');
    }

    public function chauffeursDestroy(Chauffeur $chauffeur)
    {
        if ($chauffeur->photo) Storage::disk('public')->delete($chauffeur->photo);
        $chauffeur->delete();
        return redirect()->route('gestionnaire.chauffeurs.index')->with('success','Supprimé avec succès');
    }

    // ─────────────────────────────────────────
    //  DOCUMENTS (CRUD)
    // ─────────────────────────────────────────
    public function documentsIndex()
    {
        $documents = Document::with('vehicule')->latest()->paginate(10);
        return view('gestionnaire.documents.index', compact('documents'));
    }

    public function documentsCreate()
    {
        $vehicules = Vehicule::all();
        return view('gestionnaire.documents.create', compact('vehicules'));
    }

    public function documentsStore(Request $request)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|string|max:255',
            'date_emission' => 'required|date|before_or_equal:date_expiration',
            'date_expiration' => 'required|date|after_or_equal:date_emission',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        $path = $request->file('fichier')->store('documents', 'public');

        Document::create([
            'vehicule_id' => $request->vehicule_id,
            'type' => $request->type,
            'date_emission' => $request->date_emission,
            'date_expiration' => $request->date_expiration,
            'fichier' => $path
        ]);

        return redirect()->route('gestionnaire.documents.index')->with('success','Document ajouté avec succès');
    }

    public function documentsShow(Document $document)
    {
        return view('gestionnaire.documents.show', compact('document'));
    }

    public function documentsEdit(Document $document)
    {
        $vehicules = Vehicule::all();
        return view('gestionnaire.documents.edit', compact('document', 'vehicules'));
    }

    public function documentsUpdate(Request $request, Document $document)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|string|max:255',
            'date_emission' => 'required|date|before_or_equal:date_expiration',
            'date_expiration' => 'required|date|after_or_equal:date_emission',
            'fichier' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        $data = $request->only(['vehicule_id', 'type', 'date_emission', 'date_expiration']);

        if ($request->hasFile('fichier')) {
            if ($document->fichier) Storage::disk('public')->delete($document->fichier);
            $data['fichier'] = $request->file('fichier')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('gestionnaire.documents.index')->with('success', 'Document mis à jour');
    }

    public function documentsDestroy(Document $document)
    {
        if ($document->fichier) Storage::disk('public')->delete($document->fichier);
        $document->delete();
        return redirect()->route('gestionnaire.documents.index')->with('success','Document supprimé');
    }

    // ─────────────────────────────────────────
    //  VEHICULES (CRUD)
    // ─────────────────────────────────────────
    public function vehiculesIndex()
    {
        $vehicules = Vehicule::latest()->paginate(10);
        return view('gestionnaire.vehicules.index', compact('vehicules'));
    }

    public function vehiculesCreate()
    {
        return view('gestionnaire.vehicules.create');
    }

    public function vehiculesStore(Request $request)
    {
        $data = $request->validate([
            'immatriculation' => 'required|unique:vehicules|regex:/^[A-Za-z0-9-]+$/',
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'required|integer|between:1950,' . date('Y'),
            'capacite' => 'required|integer|between:1,100',
            'statut' => 'required|in:disponible,maintenance,mission'
        ]);

        $data['immatriculation'] = strtoupper($data['immatriculation']);
        Vehicule::create($data);

        return redirect()->route('gestionnaire.vehicules.index')->with('success', 'Véhicule ajouté');
    }

    public function vehiculesShow(Vehicule $vehicule)
    {
        $vehicule->loadCount(['voyages', 'maintenances']);
        return view('gestionnaire.vehicules.show', compact('vehicule'));
    }

    public function vehiculesEdit(Vehicule $vehicule)
    {
        return view('gestionnaire.vehicules.edit', compact('vehicule'));
    }

    public function vehiculesUpdate(Request $request, Vehicule $vehicule)
    {
        $data = $request->validate([
            'immatriculation' => 'required|regex:/^[A-Za-z0-9-]+$/|unique:vehicules,immatriculation,' . $vehicule->id,
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'required|integer|between:1950,' . date('Y'),
            'capacite' => 'required|integer|between:1,100',
            'statut' => 'required|in:disponible,maintenance,mission'
        ]);

        $data['immatriculation'] = strtoupper($data['immatriculation']);
        $vehicule->update($data);

        return redirect()->route('gestionnaire.vehicules.index')->with('success', 'Véhicule modifié');
    }

    public function vehiculesDestroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('gestionnaire.vehicules.index')->with('success', 'Véhicule supprimé');
    }

    // ─────────────────────────────────────────
    //  MAINTENANCES (READ-ONLY)
    // ─────────────────────────────────────────
    public function maintenancesIndex()
    {
        $maintenances = Maintenance::with('vehicule')->latest()->paginate(10);
        return view('gestionnaire.maintenances.index', compact('maintenances'));
    }

    public function maintenancesShow(Maintenance $maintenance)
    {
        $maintenance->load('vehicule');
        return view('gestionnaire.maintenances.show', compact('maintenance'));
    }
}

