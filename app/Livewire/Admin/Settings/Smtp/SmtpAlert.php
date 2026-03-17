<?php

namespace App\Livewire\Admin\Settings\Smtp;

use App\Livewire\Admin\AComponent;
use App\Models\Setting;

class SmtpAlert extends AComponent
{
    public bool $shouldShow = false;


    public function __construct()
    {
        $admin = auth('admin')->user();

        $this->shouldShow =
            $admin
            && method_exists($admin, 'isSystem')
            && $admin->isSystem()
            && !(bool) Setting::get('mail_is_valid', false);
    }



    public function render()
    {


        return view('livewire.admin.settings.smtp.smtp-alert');

    }
}
