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
        })->with('user')->orderByDesc('created_at')->paginate(10)->appends(request()->query());
        
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

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;

        $view = "{$role}.rapports.index";
        if ($role === 'admin') $view = 'admin.rapport.index';
        if (!view()->exists($view)) $view = 'admin.rapport.index';

        return view($view, compact(
            'rapports',
            'nb_rapports',
            'vehicules',
            'voyages',
            'chauffeurs',
            'recettes_total',
            'chart_labels',
            'chart_data',
            'rolePrefix'
        ));
    }

    public function create()
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.rapports.create";
        if ($role === 'admin') $view = 'admin.rapport.create';
        if (!view()->exists($view)) $view = 'admin.rapport.create';
        
        return view($view);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'type'         => 'required|in:mensuel,trimestriel,annuel,personnalisé',
            'periode_debut'=> 'required|date',
            'periode_fin'  => 'required|date|after_or_equal:periode_debut',
            'statut'       => 'required|in:brouillon,publié',
            'notes'        => 'nullable|string|max:2000',
        ]);

        $rapport = new Rapport($validated);
        $rapport->user_id = auth()->id();
        $rapport->calculateStatistics()->save();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()
            ->route($role . '.rapports.index')
            ->with('success', 'Rapport créé avec succès.');
    }

    public function show(Rapport $rapport)
    {
        $rapport->load('user');
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.rapports.show";
        if ($role === 'admin') $view = 'admin.rapport.show';
        if (!view()->exists($view)) $view = 'admin.rapport.show';
        
        return view($view, compact('rapport', 'rolePrefix'));
    }

    public function edit(Rapport $rapport)
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.rapports.edit";
        if ($role === 'admin') $view = 'admin.rapport.edit';
        if (!view()->exists($view)) $view = 'admin.rapport.edit';
        
        return view($view, compact('rapport'));
    }

    public function update(Request $request, Rapport $rapport)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'type'         => 'required|in:mensuel,trimestriel,annuel,personnalisé',
            'periode_debut'=> 'required|date',
            'periode_fin'  => 'required|date|after_or_equal:periode_debut',
            'statut'       => 'required|in:brouillon,publié',
            'notes'        => 'nullable|string|max:2000',
        ]);

        $rapport->fill($validated);
        $rapport->calculateStatistics()->save();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()
            ->route($role . '.rapports.show', $rapport)
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    public function destroy(Rapport $rapport)
    {
        $rapport->delete();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        return redirect()
            ->route($role . '.rapports.index')
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
