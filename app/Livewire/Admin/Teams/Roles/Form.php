<?php

namespace App\Livewire\Admin\Teams\Roles;

use App\Livewire\Admin\AComponent;
use Livewire\Component;
use App\Models\Role;

class Form extends AComponent
{

    public $name;
    public $guard_name='admin';
    public $isEdit = false;
    public $object;

    public $id;

    protected $rules = [
        'name' => 'required|string|max:255|unique:'.Role::class,
    ];

    public function mount($role = null)
    {
        if ($role) {

            $role = Role::findById($role);
            $this->object = $role;
            $this->name = $role->name;
            $this->isEdit = true;
            $this->id = $role->id;
        }
    }


    public function save()
    {
        if ($this->isEdit) {
            $this->rules['name'] = 'required|string|max:255|unique:roles,name,' . $this->id;
        } else {
            $this->rules['name'] = 'required|string|max:255|unique:roles,name';
        }

        $this->validate();


        if ($this->isEdit) {
            $role = Role::findOrFail($this->id);
            $role->update([
                'name' => $this->name,
            ]);
        } else {
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
        }

        $this->id = $role->id;
        if (!$this->isEdit) {
            $this->reset();
        }
        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));

        return redirect()->route('admin.roles.edit', ['role' => $role->id]);
    }


    public function render()
    {
        return view('livewire.admin.teams.roles.form');
    }
}
