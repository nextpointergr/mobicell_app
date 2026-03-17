<?php

namespace App\Livewire\Admin\Teams\Roles;

use App\Livewire\Admin\AComponent;
use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Delete extends AComponent
{
    use AuthorizesRequests;

    public function mount(Role $role): void
    {
        $this->authorize('delete', $role);
        if ($role->is_system) {
            abort(403, 'System role cannot be deleted.');
        }
        $role->delete();
        session()->flash('success', __('Your role has been successfully deleted.'));
        $this->redirectRoute('admin.roles');
    }

    public function render()
    {
        return null;
    }
}
