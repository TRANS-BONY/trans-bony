<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignalementController extends Controller
{
    /**
     * Afficher le formulaire de signalement d'incident
     */
    public function create()
    {
        $chauffeur = Auth::user()->chauffeur;
        if (!$chauffeur) {
            return redirect()->route('dashboard')->with('error', 'Profil conducteur non trouvé.');
        }

        // Voyages récents du chauffeur pour le menu déroulant
        $voyages = Voyage::whereHas('affectations', function($q) use ($chauffeur) {
            $q->where('chauffeur_id', $chauffeur->id);
        })->orderByDesc('date_depart')->limit(5)->get();

        return view('chauffeur.signalements.create', compact('voyages'));
    }

    /**
     * Enregistrer un nouvel incident (Panne, accident, etc.)
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'voyage_id' => 'required|exists:voyages,id',
                'type' => 'required|in:panne,accident,embouteillage,meteo,autre',
                'description' => 'required|string|min:10',
                'gravite' => 'required|in:faible,moyenne,critique',
                'localisation' => 'nullable|string',
                'photo' => 'nullable|image|max:2048'
            ]);

            $data['chauffeur_id'] = Auth::user()->chauffeur->id;
            $data['statut'] = 'ouvert';

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('signalements', 'public');
            }

            Signalement::create($data);

            return back()->with('success', 'Votre signalement a été envoyé aux équipes techniques.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur signalement: " . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'envoi du signalement. Vérifiez les informations.');
        }
    }

    /**
     * Mettre à jour le statut d'un signalement (ex: Résolu par le chauffeur)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $signalement = Signalement::findOrFail($id);
            
            // Sécurité: Seul le chauffeur concerné ou un admin peut modifier
            if (Auth::user()->chauffeur->id !== $signalement->chauffeur_id && !Auth::user()->hasRole('admin')) {
                return back()->with('error', 'Action non autorisée.');
            }

            $data = $request->validate([
                'statut' => 'required|in:ouvert,pris_en_charge,resolu'
            ]);

            $signalement->update(['statut' => $data['statut']]);

            return back()->with('success', 'Statut de l\'incident mis à jour.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour.');
        }
    }
}
