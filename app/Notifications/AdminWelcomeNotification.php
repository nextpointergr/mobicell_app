<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class AdminWelcomeNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected string $plainPassword;

    public function __construct(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->subject('Your Admin Account Created')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your administrator account has been created.')
            ->line('Email: ' . $notifiable->email)
            ->line('Password: ' . $this->plainPassword)
            ->action('Login Now', route('admin.login'));
           // ->line('For security reasons, please change your password after logging in.');
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
