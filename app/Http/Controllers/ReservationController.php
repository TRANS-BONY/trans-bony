<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Voyage;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationController extends Controller
{
    /**
     * Liste des réservations
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $reservations = Reservation::with(['client', 'voyage'])
            ->when($search, function($q) use ($search) {
                return $q->where('numero_billet', 'like', "%{$search}%")
                         ->orWhereHas('client', function($q2) use ($search) {
                             $q2->where('nom', 'like', "%{$search}%")
                                ->orWhere('prenom', 'like', "%{$search}%");
                         });
            })
            ->latest()
            ->paginate(15);

        return view('agent.reservation.index', compact('reservations'));
    }

    /**
     * Formulaire de réservation (à partir d'un voyage)
     */
    public function create(Request $request)
    {
        $voyageId = $request->voyage_id;
        $voyage = Voyage::with(['vehicule', 'chauffeurs'])->findOrFail($voyageId);
        $clients = Client::orderBy('nom')->get();

        return view('agent.reservation.create', compact('voyage', 'clients'));
    }

    /**
     * Enregistrement de la réservation
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'voyage_id' => 'required|exists:voyages,id',
                'client_id' => 'required|exists:clients,id',
                'nb_passagers' => 'required|integer|min:1',
                'nb_colis' => 'required|integer|min:0',
                'poids_colis_kg' => 'nullable|numeric|min:0',
                'montant' => 'required|numeric|min:0',
                'mode_paiement' => 'required|in:espece,mobile_money,virement,en_attente',
                'siege' => 'nullable|string',
                'notes' => 'nullable|string'
            ], [
                'nb_passagers.min' => 'Réservation d\'au moins 1 passager requise.',
                'montant.required' => 'Le montant de la transaction est obligatoire.',
            ]);

            $voyage = Voyage::findOrFail($data['voyage_id']);
            
            // Vérifier capacité restante
            $dejaReserve = $voyage->reservations()->where('statut', '!=', 'annulee')->sum('nb_passagers');
            if (($dejaReserve + $data['nb_passagers']) > $voyage->vehicule->capacite) {
                return back()->with('error', "Désolé, il ne reste que " . ($voyage->vehicule->capacite - $dejaReserve) . " places disponibles.")->withInput();
            }

            $data['created_by'] = auth()->id();
            $data['statut'] = 'confirmee';
            $data['paye'] = true;
            $data['paye_le'] = now();

            $reservation = Reservation::create($data);

            // Message de succès style "Booking"
            $clientName = $reservation->client->nom ?? 'Passager';
            $msg = "Félicitations $clientName ! Votre voyage pour " . $voyage->destination . " a été réservé avec succès.";

            if (auth()->user()->hasRole('client')) {
                return redirect()->route('client.dashboard')->with('success', $msg);
            }

            return redirect()->route('agent.reservations.show', $reservation->id)
                             ->with('success', $msg);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur réservation: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la réservation.')->withInput();
        }
    }

    /**
     * Détails et options du billet
     */
    public function show($id)
    {
        $reservation = Reservation::with(['client', 'voyage.vehicule', 'voyage.affectations.chauffeur'])->findOrFail($id);
        
        // Sécurité : Un client ne peut voir que ses propres réservations
        if (auth()->user()->hasRole('client')) {
            if ($reservation->client->email !== auth()->user()->email) {
                \Log::warning("Accès non autorisé de l'utilisateur " . auth()->id() . " à la réservation $id");
                abort(403, "Vous n'avez pas l'autorisation de consulter ce billet.");
            }
        }

        return view('agent.reservation.show', compact('reservation'));
    }

    /**
     * Génération du Ticket PDF Premium
     */
    public function generateTicket($id)
    {
        $reservation = Reservation::with(['client', 'voyage.vehicule', 'voyage.affectations.chauffeur'])->findOrFail($id);
        
        // Données pour le QR Code
        $qrData = $reservation->qrData;
        
        $pdf = Pdf::loadView('agent.reservation.ticket_pdf', compact('reservation', 'qrData'))
                  ->setPaper('a5', 'landscape');

        return $pdf->stream("Billet-{$reservation->numero_billet}.pdf");
    }
}
