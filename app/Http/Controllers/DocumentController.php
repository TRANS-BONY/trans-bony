<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\DocumentExpireNotification;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('vehicule')->get();
        $vehicules = Vehicule::all();

        // 🔔 Vérification expiration (Note: Devrait idéalement être dans un Job planifié)
        // Désactivé temporairement pour performance si trop de documents
        /*
        foreach ($documents->where('date_expiration', '<', now()) as $doc) {
            try {
                if (app()->environment('production')) {
                    $admins = User::role('admin')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new DocumentExpireNotification($doc));
                    }
                }
            } catch (\Exception $e) {
                Log::error("Document notification failed: " . $e->getMessage());
            }
        }
        */

        return view('admin.document.index', compact('documents','vehicules'));
    }

    public function create()
    {
        $this->authorize('create', Document::class);
        $vehicules = Vehicule::all();
        return view('admin.document.create', compact('vehicules'));
    }

    public function adminCreate()
    {
        $vehicules = Vehicule::all();
        return view('admin.document.create', compact('vehicules'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Document::class);

        Log::info('Document store attempt', $request->all());

        // ✅ VALIDATION LOOSE
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|string|max:255',
            'date_emission' => 'required|date|before_or_equal:date_expiration',
            'date_expiration' => 'required|date|after_or_equal:date_emission',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        try {
            // 📁 UPLOAD FICHIER
            $path = $request->file('fichier')->store('documents', 'public');

            // 💾 INSERTION SECURISEE
            $document = Document::create([
                'vehicule_id' => $request->vehicule_id,
                'type' => $request->type,
                'date_emission' => $request->date_emission,
                'date_expiration' => $request->date_expiration,
                'fichier' => $path
            ]);

            Log::info('Document created', ['id' => $document->id]);

            return back()->with('success','Document ajouté avec succès');
        } catch (\Exception $e) {
            Log::error('Document create failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur DB : ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        Document::destroy($id);
        return back()->with('success','Document supprimé');
    }
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $vehicules = Vehicule::all();
        return view('admin.document.edit', compact('document', 'vehicules'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        Log::info('Document update attempt', $request->all());

        $request->validate([
            'type' => 'required|string|max:255',
            'date_emission' => 'required|date|before_or_equal:date_expiration',
            'date_expiration' => 'required|date|after_or_equal:date_emission',
            'fichier' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        try {
            $data = $request->only(['vehicule_id', 'type', 'date_emission', 'date_expiration']);

            if ($request->hasFile('fichier')) {
                // Delete old file
                if ($document->fichier && Storage::disk('public')->exists($document->fichier)) {
                    Storage::disk('public')->delete($document->fichier);
                }
                $data['fichier'] = $request->file('fichier')->store('documents', 'public');
            }

            $document->update($data);

            Log::info('Document updated', ['id' => $document->id]);

            return redirect()->route('admin.documents.index')->with('success', 'Document mis à jour avec succès');
        } catch (\Exception $e) {
            Log::error('Document update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur : ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Download document securely
     */
    public function download(Document $document)
    {
        $this->authorize('view', $document);

        if (! Storage::disk('public')->exists($document->fichier)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download($document->fichier, basename($document->fichier));
    }
}
