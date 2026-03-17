<?php

namespace App\Livewire\Admin\Settings\Profil;

use App\Livewire\Admin\AComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Index extends AComponent
{

    public string $activeTab = 'info';
    public string $name = '';
    public string $email = '';
    public ?string $password = null;

    public function mount()
    {
        $admin = Auth::guard('admin')->user();
        $this->name  = $admin->name;
        $this->email = $admin->email;
    }



    public function render()
    {
        return view('livewire.admin.settings.profil.index');
    }

    public function save()
    {
        $admin = Auth::guard('admin')->user();

        $this->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($admin->id),
            ],
            'password' => ['nullable', 'min:6'],
        ]);

        $admin->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $admin->update([
                'password' => $this->password, // γίνεται hashed λόγω cast
            ]);
        }

        session()->flash('success', __('Your changes have been saved.'));
        return redirect()->route('admin.settings.info');
    }

}
