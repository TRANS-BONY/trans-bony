<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * 🔎 Liste globale des audits
     */
    public function index(Request $request)
    {
        $audits = Audit::with('user')
            ->latest()
            ->paginate(20);

        $query = \App\Models\Maintenance::with('vehicule');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('type', 'like', '%'.$request->search.'%')
                  ->orWhereHas('vehicule', function($sub) use ($request) {
                      $sub->where('immatriculation', 'like', '%'.$request->search.'%')
                          ->orWhere('marque', 'like', '%'.$request->search.'%');
                  });
            });
        }

        $maintenances = $query->paginate(15)->appends($request->query());

        return view('audits.index', compact('audits', 'maintenances'));
    }

    /**
     * 👤 Historique par utilisateur
     */
    public function userHistory($id)
    {
        $user = User::findOrFail($id);

        $audits = Audit::where('user_id', $id)
            ->latest()
            ->paginate(20);

        return view('audits.user', compact('audits','user'));
    }

    /**
     * 🔍 Détail d’un audit
     */
    public function show($id)
    {
        $audit = Audit::with('user')->findOrFail($id);

        return view('audits.show', compact('audit'));
    }

    /**
     * 🧹 Nettoyage (admin uniquement)
     */
    public function destroy($id)
    {
        Audit::findOrFail($id)->delete();

        return back()->with('success', 'Audit supprimé');
    }

    /**
     * 🗑️ Supprimer tout (danger)
     */
    public function clear()
    {
        Audit::truncate();

        return back()->with('success', 'Tous les audits supprimés');
    }


}
