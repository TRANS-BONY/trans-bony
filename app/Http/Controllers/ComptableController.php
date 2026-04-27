<?php

namespace App\Http\Controllers;

use App\Models\RecetteMensuelle;
use App\Models\Vehicule;
use App\Models\Voyage;
use App\Models\Chauffeur;
use App\Models\Rapport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RapportExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComptableController extends Controller
{
    // ─────────────────────────────────────────
    //  DASHBOARD
    // ─────────────────────────────────────────
    public function dashboard()
    {
        // Recettes du mois courant
        $recettes_mois = RecetteMensuelle::whereMonth('date', now()->month)
                                         ->whereYear('date', now()->year)
                                         ->sum('montant');

        // Total cumulé
        $recettes_total = RecetteMensuelle::sum('montant');

        // Mois précédent pour calcul évolution
        $prev          = now()->subMonth();
        $recettes_prec = RecetteMensuelle::whereMonth('date', $prev->month)
                                          ->whereYear('date', $prev->year)
                                          ->sum('montant');

        $recettes_evolution = $recettes_prec > 0
            ? round((($recettes_mois - $recettes_prec) / $recettes_prec) * 100, 1)
            : 0;

        // Barre progression (vs max mensuel connu)
        $recettes_max = RecetteMensuelle::selectRaw('SUM(montant) as total, YEAR(date) as y, MONTH(date) as m')
                                         ->groupBy('y', 'm')
                                         ->orderByDesc('total')
                                         ->value('total') ?: 1;
        $recettes_pct = min(100, round($recettes_mois / $recettes_max * 100));

        // Compteurs
        $nb_recettes      = RecetteMensuelle::count();
        $nb_recettes_mois = RecetteMensuelle::whereMonth('date', now()->month)
                                             ->whereYear('date', now()->year)
                                             ->count();
        $nb_rapports = Rapport::count();

        // Stats globales
        $vehicules  = Vehicule::count();
        $voyages    = Voyage::count();
        $chauffeurs = Chauffeur::count();

        // Dernières recettes (5)
        $dernieres_recettes = RecetteMensuelle::orderByDesc('date')->take(5)->get();

        // Graphique — 12 derniers mois
        $chart_labels = [];
        $chart_data   = [];
        for ($i = 11; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $chart_labels[] = $d->isoFormat('MMM YY');
            $chart_data[]   = (float) RecetteMensuelle::whereMonth('date', $d->month)
                                                        ->whereYear('date', $d->year)
                                                        ->sum('montant');
        }

        // Badge sidebar
        $sidebar_recettes = $nb_recettes;

        return view('comptable.index', compact(
            'recettes_mois',
            'recettes_total',
            'recettes_evolution',
            'recettes_pct',
            'nb_recettes',
            'nb_recettes_mois',
            'nb_rapports',
            'vehicules',
            'voyages',
            'chauffeurs',
            'dernieres_recettes',
            'chart_labels',
            'chart_data',
            'sidebar_recettes'
        ));
    }

    // ─────────────────────────────────────────
    //  RECETTES — CRUD
    // ─────────────────────────────────────────
    public function recettesIndex()
    {
        $recettes = RecetteMensuelle::orderByDesc('date')->paginate(15);

        // Agrégats globaux (sur toute la table, pas seulement la page courante)
        $recettes_total      = RecetteMensuelle::sum('montant');
        $recettes_mois_total = RecetteMensuelle::whereMonth('date', now()->month)
                                                ->whereYear('date', now()->year)
                                                ->sum('montant');
        $recettes_avg        = RecetteMensuelle::avg('montant') ?? 0;
        $recettes_count      = RecetteMensuelle::count();

        return view('comptable.recettes.index', compact(
            'recettes',
            'recettes_total',
            'recettes_mois_total',
            'recettes_avg',
            'recettes_count'
        ));
    }

    public function recettesCreate()
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        return view('comptable.recettes.create', compact('vehicules'));
    }

    public function recettesStore(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'montant'     => 'required|numeric|min:0',
            'date'        => 'required|date|before_or_equal:today',
            'type'        => 'required|in:Billet,Location,Fret,Autre',
        ]);

        RecetteMensuelle::create($validated);

        return redirect()
            ->route('comptable.recettes.index')
            ->with('success', 'Recette créée avec succès.');
    }

    public function recettesShow(RecetteMensuelle $recette)
    {
        $recette->load('vehicule');
        return view('comptable.recettes.show', compact('recette'));
    }

    public function recettesEdit(RecetteMensuelle $recette)
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        return view('comptable.recettes.edit', compact('recette', 'vehicules'));
    }

    public function recettesUpdate(Request $request, RecetteMensuelle $recette)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'montant'     => 'required|numeric|min:0',
            'date'        => 'required|date|before_or_equal:today',
            'type'        => 'required|in:Billet,Location,Fret,Autre',
        ]);

        $recette->update($validated);

        return redirect()
            ->route('comptable.recettes.index')
            ->with('success', 'Recette modifiée avec succès.');
    }

    public function recettesDestroy(RecetteMensuelle $recette)
    {
        $recette->delete();

        return redirect()
            ->route('comptable.recettes.index')
            ->with('success', 'Recette supprimée avec succès.');
    }

    // ─────────────────────────────────────────
    //  RAPPORTS — CRUD
    // ─────────────────────────────────────────
    public function rapportsIndex()
    {
        $rapports       = Rapport::orderByDesc('created_at')->paginate(10);
        $nb_rapports    = Rapport::count();
        $vehicules      = Vehicule::count();
        $voyages        = Voyage::count();
        $chauffeurs     = Chauffeur::count();
        $recettes_total = RecetteMensuelle::sum('montant');

        // Graphique — 12 derniers mois
        $chart_labels = [];
        $chart_data   = [];
        for ($i = 11; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $chart_labels[] = $d->isoFormat('MMM YY');
            $chart_data[]   = (float) RecetteMensuelle::whereMonth('date', $d->month)
                                                        ->whereYear('date', $d->year)
                                                        ->sum('montant');
        }

        return view('comptable.rapports.index', compact(
            'rapports',
            'nb_rapports',
            'vehicules',
            'voyages',
            'chauffeurs',
            'recettes_total',
            'chart_labels',
            'chart_data'
        ));
    }

    public function rapportsCreate()
    {
        return view('comptable.rapports.create');
    }

    public function rapportsStore(Request $request)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'type'         => 'required|in:mensuel,trimestriel,annuel,personnalisé',
            'periode_debut'=> 'required|date',
            'periode_fin'  => 'required|date|after_or_equal:periode_debut',
            'statut'       => 'required|in:brouillon,publié',
            'notes'        => 'nullable|string|max:2000',
        ]);

        // Calcul automatique des agrégats sur la période
        $debut = Carbon::parse($validated['periode_debut'])->startOfDay();
        $fin   = Carbon::parse($validated['periode_fin'])->endOfDay();

        $validated['recettes_total'] = RecetteMensuelle::whereBetween('date', [$debut, $fin])->sum('montant');
        $validated['nb_voyages']     = Voyage::whereBetween('date_depart', [$debut, $fin])->count();
        $validated['nb_vehicules']   = Vehicule::count();
        $validated['nb_chauffeurs']  = Chauffeur::count();
        $validated['user_id']        = auth()->id();

        Rapport::create($validated);

        return redirect()
            ->route('comptable.rapports.index')
            ->with('success', 'Rapport créé avec succès.');
    }

    public function rapportsShow(Rapport $rapport)
    {
        $rapport->load('user');
        return view('comptable.rapports.show', compact('rapport'));
    }

    public function rapportsEdit(Rapport $rapport)
    {
        return view('comptable.rapports.edit', compact('rapport'));
    }

    public function rapportsUpdate(Request $request, Rapport $rapport)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'type'         => 'required|in:mensuel,trimestriel,annuel,personnalisé',
            'periode_debut'=> 'required|date',
            'periode_fin'  => 'required|date|after_or_equal:periode_debut',
            'statut'       => 'required|in:brouillon,publié',
            'notes'        => 'nullable|string|max:2000',
        ]);

        // Recalcule les agrégats sur la nouvelle période
        $debut = Carbon::parse($validated['periode_debut'])->startOfDay();
        $fin   = Carbon::parse($validated['periode_fin'])->endOfDay();

        $validated['recettes_total'] = RecetteMensuelle::whereBetween('date', [$debut, $fin])->sum('montant');
        $validated['nb_voyages']     = Voyage::whereBetween('date_depart', [$debut, $fin])->count();
        $validated['nb_vehicules']   = Vehicule::count();
        $validated['nb_chauffeurs']  = Chauffeur::count();

        $rapport->update($validated);

        return redirect()
            ->route('comptable.rapports.show', $rapport)
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    public function rapportsDestroy(Rapport $rapport)
    {
        $rapport->delete();

        return redirect()
            ->route('comptable.rapports.index')
            ->with('success', 'Rapport supprimé avec succès.');
    }

    public function rapportsPDF()
    {
        $data = [
            'vehicules' => Vehicule::count(),
            'voyages'   => Voyage::count(),
            'recettes'  => RecetteMensuelle::sum('montant'),
        ];

        $pdf = Pdf::loadView('admin.rapport.pdf', $data);
        return $pdf->download('rapport-comptable-' . now()->format('Y-m') . '.pdf');
    }

    public function rapportsExcel()
    {
        return Excel::download(new RapportExport, 'rapport-comptable-' . now()->format('Y-m') . '.xlsx');
    }
}

