<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentExpireNotification extends Notification
{
    use Queueable;

    protected $document;

    /**
     * Create a new notification instance.
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Expiration de document : ' . $this->document->type)
            ->line('Le document ' . $this->document->type . ' pour le véhicule ' . $this->document->vehicule->immatriculation . ' a expiré ou va bientôt expirer.')
            ->action('Voir le document', url('/dashboard'))
            ->line('Merci de régulariser la situation au plus vite.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Expiration : ' . $this->document->type . ' (' . $this->document->vehicule->immatriculation . ')',
            'type' => 'warning',
            'icon' => 'fas fa-exclamation-triangle',
            'url' => '/documents/' . $this->document->id
        ];
    }
}
