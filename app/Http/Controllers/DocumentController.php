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
    public function index(\Illuminate\Http\Request $request)
    {
        $search = request('search');
        $documents = Document::when($search, function($q) use ($search) {
            return $q->where(function($q2) use ($search) {
                $q2->where('type', 'like', "%{$search}%")
                   ->orWhereHas('vehicule', function($q3) use ($search) {
                       $q3->where('immatriculation', 'like', "%{$search}%")
                          ->orWhere('marque', 'like', "%{$search}%")
                          ->orWhere('modele', 'like', "%{$search}%");
                   });
            });
        })->with('vehicule')->paginate(10)->appends(request()->query());
        $vehicules = Vehicule::all();

        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.documents.index";
        if ($role === 'admin') $view = 'admin.document.index';
        if (!view()->exists($view)) $view = 'admin.document.index';

        return view($view, compact('documents','vehicules', 'rolePrefix'));
    }

    public function show(Document $document)
    {
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        $rolePrefix = $role;
        
        $view = "{$role}.documents.show";
        if ($role === 'admin') $view = 'admin.document.show';
        if (!view()->exists($view)) $view = 'admin.document.show';

        return view($view, compact('document', 'rolePrefix'));
    }

    public function create()
    {
        $vehicules = Vehicule::all();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.documents.create";
        if ($role === 'admin') $view = 'admin.document.create';
        if (!view()->exists($view)) $view = 'admin.document.create';
        
        return view($view, compact('vehicules'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Document::class);

        Log::info('Document store attempt', $request->all());

        // ✅ VALIDATION
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|string|max:255',
            'date_emission' => 'required|date',
            'date_expiration' => 'required|date|after:date_emission',
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

            return redirect()->route(auth()->user()->getRoleNames()->first() . '.documents.index')->with('success','Document ajouté avec succès');
        } catch (\Exception $e) {
            Log::error('Document create failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur DB : ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        $document->delete();
        return back()->with('success','Document supprimé');
    }
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $vehicules = Vehicule::all();
        $role = auth()->user()->getRoleNames()->first() ?: 'admin';
        
        $view = "{$role}.documents.edit";
        if ($role === 'admin') $view = 'admin.document.edit';
        if (!view()->exists($view)) $view = 'admin.document.edit';
        
        return view($view, compact('document', 'vehicules'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        Log::info('Document update attempt', $request->all());

        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|string|max:255',
            'date_emission' => 'required|date',
            'date_expiration' => 'required|date|after:date_emission',
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

            $role = auth()->user()->getRoleNames()->first() ?: 'admin';
            return redirect()->route($role . '.documents.index')->with('success', 'Document mis à jour avec succès');
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

        if (!$document->fichier || !Storage::disk('public')->exists($document->fichier)) {
            return back()->with('error', 'Le document ne contient aucun fichier ou le fichier est introuvable.');
        }

        return Storage::disk('public')->download($document->fichier, basename($document->fichier));
    }
}
