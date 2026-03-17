<?php

namespace App\Livewire\Admin\Teams\Roles;

use App\Livewire\Admin\AComponent;
use App\Livewire\Admin\AdminComponent;
use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;

class GivePermission extends AComponent
{
    public $roleId;
    public $role;
    public $permissions = [];
    public $selectAll;
    public $selectedPermissions = [];

    public function mount($role)
    {
        $this->roleId              = $role;
        $this->role                = Role::findOrFail($role);
        $this->permissions         = Permission::all();
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function save()
    {
        $this->role->syncPermissions($this->selectedPermissions);
        session()->flash('success', __('Permissions updated successfully'));
        return redirect()->route('admin.roles.permissions', ['role' => $this->roleId]);
    }
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPermissions = $this->permissions->pluck('name')->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.teams.roles.give-permission');
    }
}
