<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CarburantController extends Controller
{
    public function generatePdf(Request $request)
    {
        $search = $request->search;
        $carburants = Carburant::with('vehicule')
            ->when($search, function($q) use ($search) {
                return $q->whereHas('vehicule', function($qv) use ($search) {
                    $qv->where('immatriculation', 'like', "%{$search}%");
                })->orWhere('station', 'like', "%{$search}%");
            })
            ->latest('date')
            ->get();

        $stats = [
            'total_montant' => $carburants->sum('montant'),
            'total_litres' => $carburants->sum('quantite'),
            'nb_pleins' => $carburants->count(),
        ];

        $pdf = Pdf::loadView('admin.carburant.pdf', compact('carburants', 'stats'));
        return $pdf->download('rapport-carburant-' . now()->format('d-m-Y') . '.pdf');
    }
    public function index(Request $request)
    {
        $search = request('search');
        $carburants = Carburant::with('vehicule')
            ->when($search, function($q) use ($search) {
                return $q->whereHas('vehicule', function($qv) use ($search) {
                    $qv->where('immatriculation', 'like', "%{$search}%");
                })->orWhere('station', 'like', "%{$search}%");
            })
            ->latest('date')
            ->paginate(15)
            ->appends(request()->query());

        $vehicules = Vehicule::orderBy('immatriculation')->get();

        $user = Auth::user();
        $role = $user->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;

        $view = "{$role}.carburant.index";
        if (!view()->exists($view)) {
            $view = 'admin.carburant.index';
        }

        return view($view, compact('carburants', 'vehicules', 'rolePrefix'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date' => 'required|date',
            'quantite' => 'required|numeric|min:0.1',
            'montant' => 'required|numeric|min:0',
            'compteur_km' => 'required|integer|min:0',
            'station' => 'required|string|max:255', // Now mandatory
        ]);

        // Vérification du prix minimum (750 FCFA / litre)
        if ($data['montant'] < ($data['quantite'] * 750)) {
            return back()->withErrors(['montant' => 'Le montant est trop bas. Le prix minimum est de 750 FCFA par litre.'])->withInput();
        }

        $carburant = Carburant::create($data);

        // Update vehicle mileage if the refueling KM is higher than current
        $vehicule = Vehicule::find($data['vehicule_id']);
        if ($data['compteur_km'] > $vehicule->kilometrage) {
            $vehicule->update(['kilometrage' => $data['compteur_km']]);
        }

        return back()->with('success', 'Enregistrement de carburant ajouté');
    }

    public function update(Request $request, $id)
    {
        $carburant = Carburant::findOrFail($id);
        
        $data = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date' => 'required|date',
            'quantite' => 'required|numeric|min:0.1',
            'montant' => 'required|numeric|min:0',
            'compteur_km' => 'required|integer|min:0',
            'station' => 'required|string|max:255',
        ]);

        // Vérification du prix minimum (750 FCFA / litre)
        if ($data['montant'] < ($data['quantite'] * 750)) {
            return back()->withErrors(['montant' => 'Le montant est trop bas. Le prix minimum est de 750 FCFA par litre.'])->withInput();
        }

        $carburant->update($data);

        // Sync vehicle mileage
        $maxKm = Carburant::where('vehicule_id', $data['vehicule_id'])->max('compteur_km');
        $vehicule = Vehicule::find($data['vehicule_id']);
        if ($maxKm > $vehicule->kilometrage) {
            $vehicule->update(['kilometrage' => $maxKm]);
        }

        return back()->with('success', 'Enregistrement modifié');
    }

    public function destroy($id)
    {
        $carburant = Carburant::findOrFail($id);
        $vehiculeId = $carburant->vehicule_id;
        $carburant->delete();

        // Optional: Re-sync mileage after deletion? 
        // Better leave it as is or sync to the last known KM.
        $maxKm = Carburant::where('vehicule_id', $vehiculeId)->max('compteur_km');
        $vehicule = Vehicule::find($vehiculeId);
        if ($maxKm < $vehicule->kilometrage) {
            // We only downgrade if we're sure, but usually we don't.
        }

        return back()->with('success', 'Enregistrement supprimé');
    }
}
