<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Laravel\Sanctum\NewAccessToken;

class RequestUpdateUserPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private NewAccessToken $token)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
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
        $appName = config('app.name');

        $query = Arr::query(['token' => $this->token->plainTextToken]);

        $url = env('CHANGE_PASSWORD_FRONT_ENDPOINT', url('/')) . '?' . $query;

        return (new MailMessage)
            ->salutation("Bonjour $name")
            ->line("Vous avez oublié votre mot de passe $appName ?")
            ->line("Si vous n'avez pas demandé à renouveler votre mot de passe, vous pouvez ignore cet message.")
            ->line("Pour créer un nouveau mot de mot de passe, veuillez cliquer sur le lien sécurisé ci-dessous.")
            ->action("Changer mon mot de passe", $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray(User|Notifiable $notifiable): array
    {
        return [
            'token' => $this->token->toArray(),
            'user' => $notifiable
        ];
    }
}
