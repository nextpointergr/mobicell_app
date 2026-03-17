<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Notification;
class AdminLoginForm extends Form
{
    #[Validate('required|email')]
    public string $email = '';
    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function authenticate(): void
    {
        if (! Auth::guard('admin')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            throw ValidationException::withMessages([
                'form.email' => __('auth.failed'),
            ]);
        }
    }
}
