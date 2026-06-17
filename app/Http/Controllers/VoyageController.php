<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use Illuminate\Http\Request;

class VoyageController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = request('search');
        $voyages = Voyage::with(['vehicule', 'chauffeur'])
            ->when($search, function($q) use ($search) {
                return $q->where(function($q2) use ($search) {
                    $q2->where('destination', 'like', "%{$search}%")
                       ->orWhere('type', 'like', "%{$search}%")
                       ->orWhereHas('vehicule', function($q3) use ($search) {
                           $q3->where('immatriculation', 'like', "%{$search}%");
                       })
                       ->orWhereHas('chauffeur', function($q4) use ($search) {
                           $q4->where('nom', 'like', "%{$search}%")
                              ->orWhere('prenom', 'like', "%{$search}%");
                       });
                });
            })
            ->orderByDesc('date_depart')
            ->paginate(15)
            ->appends(request()->query());

        $vehicules = Vehicule::where('statut', 'disponible')->get();
        $chauffeurs = Chauffeur::where('actif', 1)->get();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.voyages.index";
        if ($role === 'admin' || $role === 'agent') $view = "{$role}.voyage.index";
        if (!view()->exists($view)) $view = 'admin.voyage.index';

        return view($view, compact('vehicules','chauffeurs','voyages', 'rolePrefix'));
    }

    public function show($id)
    {
        $voyage = Voyage::with(['vehicule', 'chauffeur'])->findOrFail($id);
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.voyages.show";
        if ($role === 'admin' || $role === 'agent') $view = "{$role}.voyage.show";
        if (!view()->exists($view)) $view = 'admin.voyage.show';
        
        return view($view, compact('voyage', 'rolePrefix'));
    }

    public function create()
    {
        $vehicules = Vehicule::where('statut', 'disponible')->get();
        $chauffeurs = Chauffeur::where('actif', 1)->get();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.voyages.create";
        if ($role === 'admin' || $role === 'agent') $view = "{$role}.voyage.create";
        if (!view()->exists($view)) $view = 'admin.voyage.create';
        
        return view($view, compact('vehicules', 'chauffeurs', 'rolePrefix'));
    }

    // 📅 EVENTS POUR FULLCALENDAR
    public function events()
    {
        $voyages = Voyage::with('vehicule','chauffeur')->get();

        $events = [];

        foreach ($voyages as $v) {
            $events[] = [
                'id' => $v->id,
                'title' => $v->destination . ' - ' . ($v->chauffeur->nom ?? 'N/A'),
                'start' => $v->date_depart,
                'color' => $v->type == 'maintenance' ? 'red' : 'blue'
            ];
        }

        return response()->json($events);
    }

    // ➕ CREATE
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'date_depart' => 'required|date',
            'destination' => 'required',
            'nb_passagers' => 'required|integer|min:1',
            'km_depart' => 'nullable|integer|min:0',
            'km_arrivee' => 'nullable|integer|min:0',
            'type' => 'required|in:voyage,maintenance'
        ]);

        $vehicule = Vehicule::find($data['vehicule_id']);
        $chauffeur = Chauffeur::find($data['chauffeur_id']);

        // 🚫 règles métier
        $expiredDocs = \App\Models\Document::where('vehicule_id', $vehicule->id)
            ->whereDate('date_expiration', '<', $data['date_depart'])
            ->exists();

        if ($expiredDocs) {
            return back()->withErrors(['vehicule_id' => "Le véhicule sélectionné n'est pas en règle : un ou plusieurs de ses documents seront expirés à la date de départ prévue."])->withInput();
        }
        if ($data['nb_passagers'] > $vehicule->capacite) {
            return back()->withErrors(['nb_passagers' => "La capacité de ce véhicule est de {$vehicule->capacite} passagers maximum."])->withInput();
        }

        if ($vehicule->statut == 'maintenance') {
            return back()->withErrors(['vehicule_id' => 'Véhicule en maintenance']);
        }

        if ($chauffeur->actif == 0) {
            return back()->withErrors(['chauffeur_id' => 'Chauffeur inactif']);
        }

        if (Voyage::where('vehicule_id',$vehicule->id)
            ->where('date_depart',$data['date_depart'])->exists()) {
            return back()->withErrors(['vehicule_id' => 'Véhicule occupé']);
        }

        if (Voyage::where('chauffeur_id',$chauffeur->id)
            ->where('date_depart',$data['date_depart'])->exists()) {
            return back()->withErrors(['chauffeur_id' => 'Chauffeur occupé']);
        }

        $voyage = Voyage::create($data);

        // Update vehicle mileage if arrival KM is provided
        if (isset($data['km_arrivee']) && $data['km_arrivee'] && $data['km_arrivee'] > $vehicule->kilometrage) {
            $vehicule->update(['kilometrage' => $data['km_arrivee']]);
        } elseif (isset($data['km_depart']) && $data['km_depart'] && $data['km_depart'] > $vehicule->kilometrage) {
            $vehicule->update(['kilometrage' => $data['km_depart']]);
        }

        return back()->with('success','Voyage ajouté');
    }

    // ✏️ UPDATE
    public function update(Request $request, $id)
    {
        $voyage = Voyage::findOrFail($id);

        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'date_depart' => 'required|date',
            'destination' => 'required',
            'nb_passagers' => 'required|integer|min:1',
            'km_depart' => 'nullable|integer|min:0',
            'km_arrivee' => 'nullable|integer|min:0',
            'type' => 'required'
        ]);

        $vehicule = Vehicule::find($data['vehicule_id']);
        $chauffeur = Chauffeur::find($data['chauffeur_id']);

        $expiredDocs = \App\Models\Document::where('vehicule_id', $vehicule->id)
            ->whereDate('date_expiration', '<', $data['date_depart'])
            ->exists();

        if ($expiredDocs) {
            return back()->withErrors(['vehicule_id' => "Le véhicule sélectionné n'est pas en règle : un ou plusieurs de ses documents seront expirés à la date de départ prévue."])->withInput();
        }

        if ($data['nb_passagers'] > $vehicule->capacite) {
            return back()->withErrors(['nb_passagers' => "La capacité de ce véhicule est de {$vehicule->capacite} passagers maximum."])->withInput();
        }

        if ($vehicule->statut == 'maintenance' && $voyage->vehicule_id != $data['vehicule_id']) {
            return back()->withErrors(['vehicule_id' => 'Véhicule en maintenance']);
        }

        if ($chauffeur->actif == 0) {
            return back()->withErrors(['chauffeur_id' => 'Chauffeur inactif']);
        }

        $voyage->update($data);

        // Sync vehicle mileage
        $maxKm = Voyage::where('vehicule_id', $data['vehicule_id'])->max('km_arrivee');
        $maxStartKm = Voyage::where('vehicule_id', $data['vehicule_id'])->max('km_depart');
        $finalMax = max($maxKm ?? 0, $maxStartKm ?? 0);

        if ($finalMax > $vehicule->kilometrage) {
            $vehicule->update(['kilometrage' => $finalMax]);
        }

        return back()->with('success','Modifié');
    }

    // 🖱️ DRAG & DROP
    public function move(Request $request, $id)
    {
        $voyage = Voyage::findOrFail($id);

        $newDate = $request->date;

        // 🚫 vérifier conflit
        $expiredDocs = \App\Models\Document::where('vehicule_id', $voyage->vehicule_id)
            ->whereDate('date_expiration', '<', $newDate)
            ->exists();

        if ($expiredDocs) {
            return response()->json(['error' => "Le véhicule n'est pas en règle (documents expirés pour cette date)."], 400);
        }
        if (Voyage::where('vehicule_id',$voyage->vehicule_id)
            ->where('date_depart',$newDate)
            ->where('id','!=',$id)
            ->exists()) {
            return response()->json(['error'=>'Conflit véhicule'], 400);
        }

        if (Voyage::where('chauffeur_id',$voyage->chauffeur_id)
            ->where('date_depart',$newDate)
            ->where('id','!=',$id)
            ->exists()) {
            return response()->json(['error'=>'Conflit chauffeur'], 400);
        }

        $voyage->update(['date_depart'=>$newDate]);

        return response()->json(['success'=>true, 'message' => 'Voyage déplacé avec succès']);
    }

    public function destroy($id)
    {
        try {
            $voyage = Voyage::findOrFail($id);
            $voyage->delete();

            if (request()->ajax() || request()->wantsJson() || request()->isJson()) {
                return response()->json(['success' => true, 'message' => 'Voyage supprimé avec succès']);
            }

            return back()->with('success','Voyage supprimé avec succès');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson() || request()->isJson()) {
                return response()->json(['success' => false, 'error' => 'Erreur serveur: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}
