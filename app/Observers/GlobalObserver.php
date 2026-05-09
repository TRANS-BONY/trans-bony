<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Auth;

class GlobalObserver
{
    private function notifyAdmins($message, $type = 'info', $icon = 'fas fa-info-circle', $baseUrl = null)
    {
        $admins = User::role(['admin', 'manager'])->get();
        $user = Auth::user();
        $userName = $user ? $user->name : 'Système';
        
        $fullMessage = "[$userName] $message";

        foreach ($admins as $admin) {
            $prefix = '';
            if ($admin->hasRole('admin')) {
                $prefix = '/admin';
            } elseif ($admin->hasRole('manager')) {
                $prefix = '/manager';
            }
            
            $url = $baseUrl ? url($prefix . $baseUrl) : '#';

            $admin->notify(new AppNotification([
                'message' => $fullMessage,
                'type' => $type,
                'icon' => $icon,
                'url' => $url,
            ]));
        }
    }

    // VEHICULE
    public function created_vehicule(Vehicule $v) { $this->notifyAdmins("Nouveau véhicule ajouté : {$v->immatriculation}", 'success', 'fas fa-truck', "/vehicules/{$v->id}"); }
    public function updated_vehicule(Vehicule $v) { $this->notifyAdmins("Véhicule modifié : {$v->immatriculation}", 'info', 'fas fa-truck', "/vehicules/{$v->id}"); }
    public function deleted_vehicule(Vehicule $v) { $this->notifyAdmins("Véhicule supprimé : {$v->immatriculation}", 'warning', 'fas fa-truck', "/vehicules"); }

    // CHAUFFEUR
    public function created_chauffeur(Chauffeur $c) { $this->notifyAdmins("Nouveau chauffeur : {$c->nom} {$c->prenom}", 'success', 'fas fa-user-circle', "/chauffeurs/{$c->id}"); }
    public function updated_chauffeur(Chauffeur $c) { $this->notifyAdmins("Chauffeur modifié : {$c->nom} {$c->prenom}", 'info', 'fas fa-user-circle', "/chauffeurs/{$c->id}"); }
    public function deleted_chauffeur(Chauffeur $c) { $this->notifyAdmins("Chauffeur supprimé : {$c->nom} {$c->prenom}", 'warning', 'fas fa-user-circle', "/chauffeurs"); }

    // VOYAGE
    public function created_voyage(Voyage $v) { $this->notifyAdmins("Nouveau voyage vers {$v->destination}", 'success', 'fas fa-route', "/voyages"); }
    public function updated_voyage(Voyage $v) { $this->notifyAdmins("Voyage modifié (ID: {$v->id})", 'info', 'fas fa-route', "/voyages"); }
    public function deleted_voyage(Voyage $v) { $this->notifyAdmins("Voyage annulé/supprimé vers {$v->destination}", 'warning', 'fas fa-route', "/voyages"); }

    // DOCUMENT
    public function created_document(Document $d) { $this->notifyAdmins("Document {$d->type} ajouté pour {$d->vehicule?->immatriculation}", 'success', 'fas fa-file-alt', "/documents"); }
    public function updated_document(Document $d) { $this->notifyAdmins("Document {$d->type} modifié pour {$d->vehicule?->immatriculation}", 'info', 'fas fa-file-alt', "/documents"); }
    public function deleted_document(Document $d) { $this->notifyAdmins("Document {$d->type} supprimé pour {$d->vehicule?->immatriculation}", 'warning', 'fas fa-file-alt', "/documents"); }
    
    // Generic methods that will be called by Model::observe
    public function created($model) {
        $name = class_basename($model);
        $method = "created_" . strtolower($name);
        if (method_exists($this, $method)) { $this->$method($model); }
        else { $this->notifyAdmins("Nouveau $name créé", 'success', 'fas fa-info-circle', null); }
    }

    public function updated($model) {
        $name = class_basename($model);
        $method = "updated_" . strtolower($name);
        if (method_exists($this, $method)) { $this->$method($model); }
        else { $this->notifyAdmins("$name mis à jour", 'info'); }
    }

    public function deleted($model) {
        $name = class_basename($model);
        $method = "deleted_" . strtolower($name);
        if (method_exists($this, $method)) { $this->$method($model); }
        else { $this->notifyAdmins("$name supprimé", 'warning'); }
    }
}
