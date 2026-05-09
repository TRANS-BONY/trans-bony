<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\User;
use App\Notifications\AppNotification;
use Carbon\Carbon;

class CheckAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for document expirations, voyages and maintenances';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminUsers = User::role(['admin', 'manager'])->get();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // 1. Documents expirant bientôt (dans 7 jours ou déjà expirés)
        $documents = Document::whereBetween('date_expiration', [$today, $today->copy()->addDays(7)])->get();
        foreach ($documents as $doc) {
            $msg = "Le document {$doc->type} pour le véhicule {$doc->vehicule?->immatriculation} expire le {$doc->date_expiration->format('d/m/Y')}.";
            $this->notifyUsers($adminUsers, [
                'message' => $msg,
                'type' => 'warning',
                'base_url' => '/documents',
                'icon' => 'fas fa-exclamation-triangle'
            ]);
        }

        // 2. Voyages d'aujourd'hui
        $voyages = Voyage::whereDate('date_depart', $today)->get();
        foreach ($voyages as $voyage) {
            $msg = "Voyage prévu aujourd'hui à {$voyage->date_depart->format('H:i')} vers {$voyage->destination} ({$voyage->vehicule?->immatriculation}).";
            $this->notifyUsers($adminUsers, [
                'message' => $msg,
                'type' => 'info',
                'base_url' => '/voyages',
                'icon' => 'fas fa-route'
            ]);
        }

        // 3. Maintenance demain (Prévenir 1 jour à l'avance)
        $maintenances = Maintenance::whereDate('date_prevue', $tomorrow)->get();
        foreach ($maintenances as $maint) {
            $msg = "Rappel : Maintenance prévue demain pour le véhicule {$maint->vehicule?->immatriculation} ({$maint->type}).";
            $this->notifyUsers($adminUsers, [
                'message' => $msg,
                'type' => 'warning',
                'base_url' => '/maintenances',
                'icon' => 'fas fa-tools'
            ]);
        }

        $this->info('Alerts checked and notifications sent.');
    }

    private function notifyUsers($users, $data)
    {
        foreach ($users as $user) {
            $prefix = '';
            if ($user->hasRole('admin')) {
                $prefix = '/admin';
            } elseif ($user->hasRole('manager')) {
                $prefix = '/manager';
            } elseif ($user->hasRole('technicien')) {
                $prefix = '/technicien';
            } elseif ($user->hasRole('gestionnaire')) {
                $prefix = '/gestionnaire';
            }
            
            $notifData = $data;
            if (isset($data['base_url'])) {
                $notifData['url'] = url($prefix . $data['base_url']);
            }
            
            $user->notify(new AppNotification($notifData));
        }
    }
}
