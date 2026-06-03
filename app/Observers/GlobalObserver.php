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
    /**
     * Notify users based on their roles and the context of the notification.
     */
    private function notifyRelevantRoles($message, $type = 'info', $icon = 'fas fa-info-circle', $baseUrl = null, $extraRoles = [])
    {
        // Admins and Managers always get notified
        $targetRoles = array_unique(array_merge(['admin', 'manager'], $extraRoles));
        $users = User::role($targetRoles)->get();
        
        $triggerUser = Auth::user();
        $userName = $triggerUser ? $triggerUser->name : 'Système';
        $fullMessage = "[$userName] $message";

        foreach ($users as $user) {
            // Determine the prefix for the URL based on the user's role
            $prefix = '';
            if ($user->hasRole('admin')) $prefix = '/admin';
            elseif ($user->hasRole('manager')) $prefix = '/manager';
            elseif ($user->hasRole('agent')) $prefix = '/agent';
            elseif ($user->hasRole('technicien')) $prefix = '/technicien';
            elseif ($user->hasRole('gestionnaire')) $prefix = '/gestionnaire';
            elseif ($user->hasRole('comptable')) $prefix = '/comptable';
            
            $url = $baseUrl ? url($prefix . $baseUrl) : '#';

            $user->notify(new AppNotification([
                'message' => $fullMessage,
                'type' => $type,
                'icon' => $icon,
                'url' => $url,
            ]));
        }
    }

    // VEHICULE
    public function created_vehicule(Vehicule $v) { $this->notifyRelevantRoles("Nouveau véhicule ajouté : {$v->immatriculation}", 'success', 'fas fa-bus', "/vehicules/{$v->id}", ['gestionnaire', 'technicien']); }
    public function updated_vehicule(Vehicule $v) { $this->notifyRelevantRoles("Véhicule modifié : {$v->immatriculation}", 'info', 'fas fa-bus', "/vehicules/{$v->id}", ['gestionnaire', 'technicien']); }
    public function deleted_vehicule(Vehicule $v) { $this->notifyRelevantRoles("Véhicule supprimé : {$v->immatriculation}", 'warning', 'fas fa-bus', "/vehicules", ['gestionnaire']); }

    // CHAUFFEUR
    public function created_chauffeur(Chauffeur $c) { $this->notifyRelevantRoles("Nouveau chauffeur : {$c->nom}", 'success', 'fas fa-user-tie', "/chauffeurs/{$c->id}", ['gestionnaire', 'agent']); }
    public function updated_chauffeur(Chauffeur $c) { $this->notifyRelevantRoles("Chauffeur modifié : {$c->nom}", 'info', 'fas fa-user-tie', "/chauffeurs/{$c->id}", ['gestionnaire', 'agent']); }
    public function deleted_chauffeur(Chauffeur $c) { $this->notifyRelevantRoles("Chauffeur supprimé : {$c->nom}", 'warning', 'fas fa-user-tie', "/chauffeurs", ['gestionnaire']); }

    // VOYAGE
    public function created_voyage(Voyage $v) { $this->notifyRelevantRoles("Nouveau voyage vers {$v->destination}", 'success', 'fas fa-route', "/voyages/{$v->id}", ['agent']); }
    public function updated_voyage(Voyage $v) { $this->notifyRelevantRoles("Voyage modifié (ID: {$v->id})", 'info', 'fas fa-route', "/voyages/{$v->id}", ['agent']); }
    public function deleted_voyage(Voyage $v) { $this->notifyRelevantRoles("Voyage supprimé vers {$v->destination}", 'warning', 'fas fa-route', "/voyages", ['agent']); }

    // DOCUMENT
    public function created_document(Document $d) { $this->notifyRelevantRoles("Document {$d->type} ajouté pour {$d->vehicule?->immatriculation}", 'success', 'fas fa-file-invoice', "/documents", ['gestionnaire']); }
    public function updated_document(Document $d) { $this->notifyRelevantRoles("Document {$d->type} modifié pour {$d->vehicule?->immatriculation}", 'info', 'fas fa-file-invoice', "/documents", ['gestionnaire']); }
    public function deleted_document(Document $d) { $this->notifyRelevantRoles("Document {$d->type} supprimé", 'warning', 'fas fa-file-invoice', "/documents", ['gestionnaire']); }
    
    // MAINTENANCE
    public function created_maintenance(Maintenance $m) { $this->notifyRelevantRoles("Nouvelle maintenance pour {$m->vehicule?->immatriculation}", 'success', 'fas fa-tools', "/maintenances/{$m->id}", ['technicien']); }
    public function updated_maintenance(Maintenance $m) { $this->notifyRelevantRoles("Maintenance modifiée pour {$m->vehicule?->immatriculation} (Statut: {$m->statut})", 'info', 'fas fa-tools', "/maintenances/{$m->id}", ['technicien']); }
    public function deleted_maintenance(Maintenance $m) { $this->notifyRelevantRoles("Maintenance supprimée", 'warning', 'fas fa-tools', "/maintenances", ['technicien']); }
    
    // RAPPORT
    public function created_rapport(\App\Models\Rapport $r) { $this->notifyRelevantRoles("Nouveau rapport généré : {$r->titre}", 'success', 'fas fa-chart-bar', "/rapports/{$r->id}", ['comptable']); }
    public function updated_rapport(\App\Models\Rapport $r) { $this->notifyRelevantRoles("Rapport modifié : {$r->titre}", 'info', 'fas fa-chart-bar', "/rapports/{$r->id}", ['comptable']); }
    public function deleted_rapport(\App\Models\Rapport $r) { $this->notifyRelevantRoles("Rapport supprimé", 'warning', 'fas fa-chart-bar', "/rapports", ['comptable']); }

    // RECETTE
    public function created_recettemensuelle(\App\Models\RecetteMensuelle $rm) { $this->notifyRelevantRoles("Recette enregistrée : " . number_format($rm->montant, 0, ',', ' ') . " FCFA", 'success', 'fas fa-wallet', "/recettes/{$rm->id}", ['comptable']); }
    public function updated_recettemensuelle(\App\Models\RecetteMensuelle $rm) { $this->notifyRelevantRoles("Recette modifiée", 'info', 'fas fa-wallet', "/recettes/{$rm->id}", ['comptable']); }
    public function deleted_recettemensuelle(\App\Models\RecetteMensuelle $rm) { $this->notifyRelevantRoles("Recette supprimée", 'warning', 'fas fa-wallet', "/recettes", ['comptable']); }
    
    // Guard against recursive observer calls (infinite loop)
    private static bool $isNotifying = false;

    // Generic methods
    public function created($model) {
        if (self::$isNotifying) return;
        self::$isNotifying = true;
        try {
            $name = class_basename($model);
            $method = "created_" . strtolower($name);
            if (method_exists($this, $method)) { $this->$method($model); }
            else { $this->notifyRelevantRoles("Nouveau $name créé", 'success', 'fas fa-plus-circle', null); }
        } finally {
            self::$isNotifying = false;
        }
    }

    public function updated($model) {
        if (self::$isNotifying) return;
        self::$isNotifying = true;
        try {
            $name = class_basename($model);
            $method = "updated_" . strtolower($name);
            if (method_exists($this, $method)) { $this->$method($model); }
            else { $this->notifyRelevantRoles("$name mis à jour", 'info', 'fas fa-edit', null); }
        } finally {
            self::$isNotifying = false;
        }
    }

    public function deleted($model) {
        if (self::$isNotifying) return;
        self::$isNotifying = true;
        try {
            $name = class_basename($model);
            $method = "deleted_" . strtolower($name);
            if (method_exists($this, $method)) { $this->$method($model); }
            else { $this->notifyRelevantRoles("$name supprimé", 'warning', 'fas fa-trash-alt', null); }
        } finally {
            self::$isNotifying = false;
        }
    }
}
