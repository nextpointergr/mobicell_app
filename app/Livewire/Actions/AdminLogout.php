<?php

namespace App\Livewire\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AdminLogout
{
    public function __invoke(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
