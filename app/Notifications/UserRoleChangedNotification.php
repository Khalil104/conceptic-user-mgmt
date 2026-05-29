<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRoleChangedNotification extends Notification
{
    use Queueable;

    protected string $newRole;

    /**
     * Le constructeur qui reçoit les données nécessaires
     */
    public function __construct(string $newRole)
    {
       $this->newRole = $newRole;
    }

    /**
     * Définition des canaux d'envoi
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }

    public function shouldQueue(object $notifiable): bool
    {
        return app()->environment() != 'local';
    }

    /**
     * Canal E-mail : Génère un mail responsive nativement
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Conceptic - Mise à jour de votre compte')
            ->greeting("Bonjour {$notifiable->name},")
            ->line('Un administrateur vient de modifier vos privilèges sur la plateforme Conceptic.')
            ->line("Votre nouveau rôle est désormais : **" . ucfirst($this->newRole) . "**.")
            ->action('Accéder à mon tableau de bord', url('/me'))
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur, veuillez contacter le support.');
    }

    /**
     * Canal Base de données Ce JSON sera stocké dans la table `notifications`
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Changement de rôle',
            'message' => "Votre rôle a été modifié en " . ucfirst($this->newRole) . ".",
            'action_url' => '/me',
            'icon' => 'user-shield',
            'user_name' => $notifiable->name 
        ];
    }
}
