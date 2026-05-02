<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Models\RecetteMensuelle;
use App\Models\Rapport;

class ManagerController extends Controller
{
    // ─────────────────────────────────────────
    //  DASHBOARD
    // ─────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'vehicules' => Vehicule::count(),
            'chauffeurs' => Chauffeur::count(),
            'voyages' => Voyage::count(),
            'voyages_en_cours' => Voyage::where('statut', 'en cours')->count(),
            'maintenances' => Maintenance::count(),
            'recettes_total' => RecetteMensuelle::sum('montant'),
        ];

        $derniers_voyages = Voyage::with(['vehicule', 'chauffeur'])->latest('created_at')->take(5)->get();
        $dernieres_maintenances = Maintenance::with('vehicule')->latest('created_at')->take(5)->get();

        return view('manager.dashboard', compact('stats', 'derniers_voyages', 'dernieres_maintenances'));
    }

    // ─────────────────────────────────────────
    //  VEHICULES
    // ─────────────────────────────────────────
    public function vehiculesIndex()
    {
        $vehicules = Vehicule::orderBy('immatriculation')->paginate(12);
        return view('manager.vehicules.index', compact('vehicules'));
    }

    public function vehiculesShow(Vehicule $vehicule)
    {
        $vehicule->load(['maintenances', 'voyages', 'documents']);
        return view('manager.vehicules.show', compact('vehicule'));
    }

    // ─────────────────────────────────────────
    //  CHAUFFEURS
    // ─────────────────────────────────────────
    public function chauffeursIndex()
    {
        $chauffeurs = Chauffeur::orderBy('nom')->paginate(12);
        return view('manager.chauffeurs.index', compact('chauffeurs'));
    }

    public function chauffeursShow(Chauffeur $chauffeur)
    {
        $chauffeur->load('voyages');
        return view('manager.chauffeurs.show', compact('chauffeur'));
    }

    // ─────────────────────────────────────────
    //  VOYAGES
    // ─────────────────────────────────────────
    public function voyagesIndex()
    {
        $voyages = Voyage::with(['vehicule', 'chauffeur'])->orderByDesc('date_depart')->paginate(15);
        return view('manager.voyages.index', compact('voyages'));
    }

    public function voyagesShow($id)
    {
        $voyage = Voyage::with(['vehicule', 'chauffeur'])->findOrFail($id);
        return view('manager.voyages.show', compact('voyage'));
    }

    // ─────────────────────────────────────────
    //  MAINTENANCES
    // ─────────────────────────────────────────
    public function maintenancesIndex()
    {
        $maintenances = Maintenance::with('vehicule')->orderByDesc('date_prevue')->paginate(15);
        return view('manager.maintenances.index', compact('maintenances'));
    }

    public function maintenancesShow(Maintenance $maintenance)
    {
        $maintenance->load('vehicule');
        return view('manager.maintenances.show', compact('maintenance'));
    }

    // ─────────────────────────────────────────
    //  DOCUMENTS
    // ─────────────────────────────────────────
    public function documentsIndex()
    {
        $documents = Document::with('vehicule')->orderByDesc('date_expiration')->paginate(15);
        return view('manager.documents.index', compact('documents'));
    }

    public function documentsShow(Document $document)
    {
        $document->load('vehicule');
        return view('manager.documents.show', compact('document'));
    }

    // ─────────────────────────────────────────
    //  FINANCES / RECETTES
    // ─────────────────────────────────────────
    public function recettesIndex()
    {
        $recettes = RecetteMensuelle::with('vehicule')->orderByDesc('date')->paginate(15);
        return view('manager.recettes.index', compact('recettes'));
    }

    public function recettesShow(RecetteMensuelle $recette)
    {
        $recette->load('vehicule');
        return view('manager.recettes.show', compact('recette'));
    }

    // ─────────────────────────────────────────
    //  RAPPORTS
    // ─────────────────────────────────────────
    public function rapportsIndex()
    {
        $rapports = Rapport::with('user')->orderByDesc('created_at')->paginate(15);
        return view('manager.rapports.index', compact('rapports'));
    }

    public function rapportsShow(Rapport $rapport)
    {
        $rapport->load('user');
        return view('manager.rapports.show', compact('rapport'));
    }

    // ─────────────────────────────────────────
    //  AUDITS
    // ─────────────────────────────────────────
    public function auditsIndex()
    {
        $audits = \App\Models\Audit::latest()->paginate(20);
        return view('manager.audits.index', compact('audits'));
    }

    public function auditsShow($id)
    {
        $audit = \App\Models\Audit::findOrFail($id);
        return view('manager.audits.show', compact('audit'));
    }

    // ─────────────────────────────────────────
    //  UTILISATEURS
    // ─────────────────────────────────────────
    public function usersIndex()
    {
        $users = \App\Models\User::orderBy('name')->paginate(15);
        return view('manager.users.index', compact('users'));
    }

    public function usersShow($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('manager.users.show', compact('user'));
    }
}

