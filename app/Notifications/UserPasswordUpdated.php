<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class UserPasswordUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param User|Notifiable|string $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User|Notifiable|string $notifiable
     * @return MailMessage
     */
    public function toMail(User|Notifiable|string $notifiable): MailMessage
    {
        $name = $notifiable instanceof User ? $notifiable->name : '';

        return (new MailMessage)
            ->line("Bonjour $name")
            ->line('Nous vous informons que votre mot de passe a bien été modifié')
            ->line("contactez le support si cette action ne vient pas de vous")
            ->line('Nous vous remercions de votre confiance')
            ->line('Bien cordialement');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'Notification de changement de mot de passe'
        ];
    }
}
