<?php

namespace App\Livewire\Admin\Settings\Generally;
use App\Livewire\Admin\AComponent;
use App\Models\Setting;

class Index extends AComponent
{

    public string $activeTab = 'generally';
    public string $app_name;
    public string $email_notification;
    public bool $notify_on_login;
    public bool $notify_on_login_sms;
    public bool $notify_on_login_email;

    protected array $rules = [
        'email_notification' => 'required|email'
    ];

    public function mount()
    {
        $this->email_notification       = Setting::get('email_notification','');
        $this->notify_on_login          = (bool) Setting::get('notify_on_login', false);
        $this->notify_on_login_sms      = (bool) Setting::get('notify_on_login_sms', false);
        $this->notify_on_login_email    = (bool) Setting::get('notify_on_login_email', false);
    }

    public function render()
    {
        return view('livewire.admin.settings.generally.index');
    }

    public function save()
    {
        $this->validate();
        Setting::set('email_notification'   , $this->email_notification);
        Setting::set('notify_on_login', $this->notify_on_login);
        Setting::set('notify_on_login_sms', $this->notify_on_login_sms);
        Setting::set('notify_on_login_email', $this->notify_on_login_email);
        session()->flash('success',  __('Your changes have been saved.'));
        return redirect()->route('admin.settings.general');
    }





}
