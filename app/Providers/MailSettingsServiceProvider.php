<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class MailSettingsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {

            if (!\Schema::hasTable('settings')) {
                return;
            }



            Config::set('mail.default', Setting::get('mail_mailer', 'smtp'));

            Config::set('mail.mailers.smtp', [
                'transport'  => 'smtp',
                'host'       => Setting::get('mail_host'),
                'port'       => (int) Setting::get('mail_port'),
                'encryption' => Setting::get('mail_encryption'),
                'username'   => Setting::get('mail_username'),
                'password'   => Setting::get('mail_password'),
                'timeout'    => null,
                'auth_mode'  => null,
            ]);

            Config::set('mail.from', [
                'address' => Setting::get('mail_from_address'),
                'name'    => Setting::get('mail_from_name'),
            ]);

        } catch (\Throwable $e) {
            report($e);
        }
    }
}
