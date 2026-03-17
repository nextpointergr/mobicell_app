<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    protected $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }



    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Login Detected')
            ->greeting('Login Alert')
            ->line('A new login was detected.')
            ->line('User: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('IP Address: ' . request()->ip())
            ->line('Time: ' . now()->format('d/m/Y H:i'))
            ->line('If this was not you, please secure your account.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
