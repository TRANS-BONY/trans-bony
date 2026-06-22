<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Voyage;

class NewMissionNotification extends Notification
{
    use Queueable;

    protected $voyage;

    public function __construct(Voyage $voyage)
    {
        $this->voyage = $voyage;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'voyage_id' => $this->voyage->id,
            'destination' => $this->voyage->destination,
            'date_depart' => $this->voyage->date_depart->format('d/m/Y H:i'),
            'type' => $this->voyage->type,
            'message' => "Nouvelle mission de voyage pour {$this->voyage->destination} le {$this->voyage->date_depart->format('d/m/Y')}.",
        ];
    }
}
