<?php

namespace App\Jobs;

use App\Models\Setting;
use App\Notifications\TestMailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmtpTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $email)
    {
    }
    public function handle(): void
    {
        Notification::route('mail', $this->email)
            ->notify(new TestMailNotification());
        Setting::set('mail_is_valid', true);
        Setting::set('mail_last_tested_at', now());
    }

    public function failed(\Throwable $exception): void
    {
        Setting::set('mail_is_valid', false);
        Setting::set('mail_last_error', $exception->getMessage());
    }
}
