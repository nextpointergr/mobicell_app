<?php

namespace App\Livewire\Admin\Teams\Employees;

use App\Livewire\Admin\AComponent;
use App\Models\Employee;
use App\Notifications\AdminWelcomeNotification;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class Form extends AComponent
{
    public $id;
    public $name;
    public $email;
    public $id_role;
    public $isEdit = false;
    public Employee $employee;

    public $roles = [];
    protected function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')
                    ->ignore($this->id)
                    ->whereNull('deleted_at'),
            ],
            'id_role'  => 'required|exists:roles,id',

        ];
    }

    public function mount(?Employee $employee = null)
    {
        $this->roles = Role::orderBy('name')->get();
        if ($employee) {
            $this->employee = $employee;
            $this->id     = $employee->id;
            $this->name   = $employee->name;
            $this->email  = $employee->email;
            $this->id_role = $employee->roles()->first()?->id;
            $this->isEdit = true;
        }
    }

    public function save($redirect = 'edit')
    {
        $this->validate();
        if ($this->isEdit) {
            $employee = Employee::findOrFail($this->id);
            $employee->update([
                'name'  => $this->name,
                'email' => $this->email
            ]);
            $message = __('Employee details have been updated successfully.');
        } else {

            $existing = Employee::withTrashed()
                ->where('email', $this->email)
                ->first();
            if ($existing) {

                if ($existing->trashed()) {
                    $existing->restore();
                    $plainPassword = Str::password(12);
                    $existing->update([
                        'name'     => $this->name,
                        'password' => Hash::make($plainPassword),
                    ]);
                    $existing->notify(new AdminWelcomeNotification($plainPassword));
                    $employee = $existing;
                    $message = __('The employee account has been restored. New login credentials have been sent via email.');
                }

            } else {
                $plainPassword = Str::random(10);
                $employee = Employee::create([
                    'name'     => $this->name,
                    'email'    => $this->email,
                    'password' => Hash::make($plainPassword),
                ]);
                $employee->notify(new AdminWelcomeNotification($plainPassword));
                $message = __('The employee has been created successfully. Login credentials have been sent via email.');
            }
            $this->id = $employee->id;
        }

        if (!$employee->is_system) {
            $role = Role::findById($this->id_role);
            $employee->syncRoles([$role->name]);
        }

        if ($redirect ==='stay')
        {
            return redirect()
                ->route('admin.employees.create')
                ->with('success', $message);
        }
        if ($redirect === 'list') {
            return redirect()
                ->route('admin.employees')
                ->with('success', $message);
        }

        return redirect()
            ->route('admin.employees.edit', $employee->id)
            ->with('success', $message);


    }

    public function render()
    {
        return view('livewire.admin.teams.employees.form');
    }
}
