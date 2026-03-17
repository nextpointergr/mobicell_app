<?php

namespace App\Livewire\Admin\Settings\Smtp;

use App\Jobs\SendSmtpTestJob;
use App\Livewire\Admin\AComponent;
use App\Models\Setting;
use App\Notifications\TestMailNotification;
use Illuminate\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Artisan;

class Index extends AComponent
{

    public string $activeTab = 'smtp';

    public $mail_mailer = 'smtp';
    public $test_email = '';
    public $mail_host;
    public $mail_port = 587;
    public $mail_username;
    public $mail_password;
    public $mail_encryption = 'tls';
    public $mail_from_address;
    public $mail_from_name;


    protected $rules = [
        'mail_mailer' => 'required|string',
        'mail_host' => 'required|string',
        'mail_port' => 'required|numeric',
        'mail_username' => 'required|string',
        'mail_password' => 'required|string',
        'mail_encryption' => 'nullable|string',
        'mail_from_address' => 'required|email',
        'mail_from_name' => 'required|string',
    ];


    public function mount()
    {
        $this->mail_mailer = Setting::get('mail_mailer', 'smtp');
        $this->mail_host = Setting::get('mail_host');
        $this->mail_port = Setting::get('mail_port', 587);
        $this->mail_username = Setting::get('mail_username');
        $this->mail_password = Setting::get('mail_password');
        $this->mail_encryption = Setting::get('mail_encryption', 'tls');
        $this->mail_from_address = Setting::get('mail_from_address');
        $this->mail_from_name = Setting::get('mail_from_name');
    }

    public function save()
    {
        $this->validate();
        Setting::set('mail_mailer', $this->mail_mailer);
        Setting::set('mail_host', $this->mail_host);
        Setting::set('mail_port', $this->mail_port);
        Setting::set('mail_username', $this->mail_username);
        Setting::set('mail_password', $this->mail_password);
        Setting::set('mail_encryption', $this->mail_encryption);
        Setting::set('mail_from_address', $this->mail_from_address);
        Setting::set('mail_from_name', $this->mail_from_name);

        Setting::set('mail_is_valid', false);


        session()->flash('success',  __('Your changes have been saved.'));

        return redirect()->route('admin.settings.smtp');
    }

    public function render()
    {
        return view('livewire.admin.settings.smtp.index');
    }

    public function sendTestEmail()
    {
        $this->validate([
            'test_email' => ['required', 'email'],
        ]);

        try {


            app()->forgetInstance('mail.manager');
            app()->forgetInstance('mailer');


            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp' => [
                    'transport'  => 'smtp',
                    'host'       => Setting::get('mail_host'),
                    'port'       => (int) Setting::get('mail_port'),
                    'encryption' => Setting::get('mail_encryption'),
                    'username'   => Setting::get('mail_username'),
                    'password'   => Setting::get('mail_password'),
                    'timeout'    => null,
                    'auth_mode'  => null,
                ],
                'mail.from.address' => Setting::get('mail_from_address'),
                'mail.from.name'    => Setting::get('mail_from_name'),
            ]);

            SendSmtpTestJob::dispatch($this->test_email);
            session()->flash('success', 'Test email queued. You will be notified after processing.');

        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {

            Setting::set('mail_is_valid', false);
            Setting::set('mail_last_error', $e->getMessage());

            session()->flash(
                'error',
                __('SMTP connection failed: ') . $e->getMessage()
            );

        } catch (\Throwable $e) {

            Setting::set('mail_is_valid', false);
            Setting::set('mail_last_error', $e->getMessage());

            session()->flash(
                'error',
                __('Unexpected error: ') . $e->getMessage()
            );
        }

        return redirect()->route('admin.settings.smtp');
    }

}
