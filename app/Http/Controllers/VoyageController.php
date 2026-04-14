<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use Illuminate\Http\Request;

class VoyageController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::all();
        $chauffeurs = Chauffeur::all();

return view('admin.voyage.index', compact('vehicules','chauffeurs'));
    }

    // 📅 EVENTS POUR FULLCALENDAR
    public function events()
    {
        $voyages = Voyage::with('vehicule','chauffeur')->get();

        $events = [];

        foreach ($voyages as $v) {
            $events[] = [
                'id' => $v->id,
                'title' => $v->destination . ' - ' . $v->chauffeur->nom,
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
            'nb_passagers' => 'required|integer',
            'type' => 'required|in:voyage,maintenance'
        ]);

        $vehicule = Vehicule::find($data['vehicule_id']);
        $chauffeur = Chauffeur::find($data['chauffeur_id']);

        // 🚫 règles métier
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

        Voyage::create($data);

        return back()->with('success','Voyage ajouté');
    }

    // ✏️ UPDATE
    public function update(Request $request, $id)
    {
        $voyage = Voyage::findOrFail($id);

        $data = $request->validate([
            'vehicule_id' => 'required',
            'chauffeur_id' => 'required',
            'date_depart' => 'required|date',
            'destination' => 'required',
            'nb_passagers' => 'required|integer|between:0,52',
            'type' => 'required'
        ]);

        $vehicule = Vehicule::find($data['vehicule_id']);
        $chauffeur = Chauffeur::find($data['chauffeur_id']);

        if ($vehicule->statut == 'maintenance') {
            return back()->withErrors(['vehicule_id' => 'Véhicule en maintenance']);
        }

        if ($chauffeur->actif == 0) {
            return back()->withErrors(['chauffeur_id' => 'Chauffeur inactif']);
        }

        $voyage->update($data);

        return back()->with('success','Modifié');
    }

    // 🖱️ DRAG & DROP
    public function move(Request $request, $id)
    {
        $voyage = Voyage::findOrFail($id);

        $newDate = $request->date;

        // 🚫 vérifier conflit
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

        return response()->json(['success'=>true]);
    }

    public function destroy($id)
    {
        Voyage::destroy($id);
        return back()->with('success','Supprimé');
    }
}
