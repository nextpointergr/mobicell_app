<?php

namespace App\Livewire\Admin\Teams\Employees;
use App\Livewire\Admin\AComponent;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Delete extends AComponent
{
    use AuthorizesRequests;
    public function mount(Employee $admin): void
    {
        $this->authorize('delete', $admin);
        if ($admin->is_system) {
            abort(403, 'System admin cannot be deleted.');
        }
        $admin->delete();
        session()->flash('success', __('Your employee has been successfully deleted.'));
        $this->redirectRoute('admin.employees');
    }

    public function render()
    {
        return view('livewire.empty');
    }
}
