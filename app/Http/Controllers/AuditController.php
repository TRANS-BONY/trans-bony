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
        $search = request('search');
        $audits = Audit::when($search, function($q) use ($search) {
            return $q->where(function($q2) use ($search) {
                $q2->where('action', 'like', "%{$search}%")
                   ->orWhere('table_name', 'like', "%{$search}%")
                   ->orWhereHas('user', function($query) use ($search) {
                       $query->where('name', 'like', "%{$search}%");
                   });
            });
        })->with('user')->latest()->paginate(20)->appends(request()->query());

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $view = 'admin.audits.index';
        if ($role === 'manager') $view = 'manager.audits.index';

        return view($view, compact('audits'));
    }

    /**
     * 👤 Historique par utilisateur
     */
    public function userHistory($id)
    {
        $user = User::findOrFail($id);

        $audits = Audit::where('user_id', $id)
            ->with('user')
            ->latest()
            ->paginate(20)
            ->appends(request()->query());

        return view('admin.audits.index', compact('audits','user'));
    }

    /**
     * 🔍 Détail d’un audit
     */
    public function show($id)
    {
        $audit = Audit::with('user')->findOrFail($id);
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $view = 'admin.audits.show';
        if ($role === 'manager') $view = 'manager.audits.show';

        return view($view, compact('audit'));
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
