<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Voyage;
use App\Models\Chauffeur;
use App\Models\RecetteMensuelle;
use App\Models\Rapport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RapportExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = request('search');
        $rapports = Rapport::when($search, function($q) use ($search) {
            return $q->where(function($q2) use ($search) {
                $q2->where('titre', 'like', "%{$search}%")
                ;
            });
        })->orderByDesc('created_at')->paginate(10)->appends(request()->query());
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

        return view('admin.rapport.index', compact(
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

    public function create()
    {
        return view('admin.rapport.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'type'         => 'required|in:mensuel,trimestriel,annuel,personnalisé',
            'periode_debut'=> 'required|date|after_or_equal:today',
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
            ->route('admin.rapports.index')
            ->with('success', 'Rapport créé avec succès.');
    }

    public function show(Rapport $rapport)
    {
        $rapport->load('user');
        return view('admin.rapport.show', compact('rapport'));
    }

    public function edit(Rapport $rapport)
    {
        return view('admin.rapport.edit', compact('rapport'));
    }

    public function update(Request $request, Rapport $rapport)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'type'         => 'required|in:mensuel,trimestriel,annuel,personnalisé',
            'periode_debut'=> 'required|date|after_or_equal:today',
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
            ->route('admin.rapports.show', $rapport)
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    public function destroy(Rapport $rapport)
    {
        $rapport->delete();

        return redirect()
            ->route('admin.rapports.index')
            ->with('success', 'Rapport supprimé avec succès.');
    }

    public function exportPDF()
    {
        // Check permission
        if (! auth('web')->user()->hasPermissionTo('voir rapports')) {
            abort(403, 'Permission refusée');
        }

        $data = [
            'vehicules' => Vehicule::count(),
            'voyages'   => Voyage::count(),
            'recettes'  => RecetteMensuelle::sum('montant'),
        ];

        $pdf = Pdf::loadView('admin.rapport.pdf', $data);
        return $pdf->download('rapport-admin-' . now()->format('Y-m') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new RapportExport, 'rapport-admin-' . now()->format('Y-m') . '.xlsx');
    }
}
