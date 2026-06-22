<?php

namespace App\Http\Controllers;

use App\Models\Voyage;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientBookingController extends Controller
{
    /**
     * Page d'accueil / Recherche de voyages
     */
    public function index(Request $request)
    {
        $destinations = Voyage::distinct()->pluck('destination');
        
        $query = Voyage::with(['vehicule', 'affectations.chauffeur', 'reservations'])
            ->where('date_depart', '>', now())
            ->where('type', 'voyage');

        if ($request->filled('destination')) {
            $query->where('destination', $request->destination);
        }

        if ($request->filled('date')) {
            $query->whereDate('date_depart', $request->date);
        }

        $voyages = $query->orderBy('date_depart')->paginate(10);

        return view('client.booking.index', compact('voyages', 'destinations'));
    }

    /**
     * Détails d'un voyage et formulaire de réservation
     */
    public function show(Voyage $voyage)
    {
        // Vérifier capacité restante
        $dejaReserve = $voyage->reservations()->where('statut', '!=', 'annulee')->sum('nb_passagers');
        $placesDispo = $voyage->vehicule->capacite - $dejaReserve;

        return view('client.booking.show', compact('voyage', 'placesDispo'));
    }

    /**
     * Tableau de bord du client (Mes billets)
     */
    public function dashboard()
    {
        $user = Auth::user();
        // Un utilisateur client doit être lié à un profil Client via mail ou autre
        // Pour l'instant, on cherche les réservations liées à l'email de l'user
        $reservations = Reservation::with(['voyage.vehicule', 'client'])
            ->whereHas('client', function($q) use ($user) {
                $q->where('email', $user->email);
            })
            ->latest()
            ->get();

        return view('client.dashboard', compact('reservations'));
    }
}
