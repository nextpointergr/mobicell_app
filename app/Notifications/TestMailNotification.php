<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestMailNotification extends Notification
{
    use Queueable;


    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('SMTP Test Email')
            ->line('If you received this email, SMTP works correctly.');
    }


    public function handle($notifiable)
    {
        Setting::set('mail_is_valid', true);
        Setting::set('mail_last_tested_at', now());
    }

}
