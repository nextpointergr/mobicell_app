<?php

namespace App\Livewire\Admin\Teams\Employees;
use App\Livewire\Admin\AComponent;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Notifications\AdminWelcomeNotification;

class Index extends AComponent
{
    use withPagination;
    use WithoutUrlPagination;
    protected $listeners = [
        'reorderEmployees',
    ];

    public $search;
    public $confirmingResendId = null;
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function reorderEmployees(array $ids)
    {
        Gate::authorize('admin.employees.sorting');
        foreach ($ids as $index => $id) {
            Employee::where('id', $id)->update([
                'position' => $index + 1,
            ]);
        }
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('Order updated successfully'),
        ]);
    }

    public function render()
    {
        $search = $this->search ?? '';
        $perPage = get_system_pagination();
        $query = Employee::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        $items = $query->paginate($perPage);
        $count = Employee::count();
        return view('livewire.admin.teams.employees.index', compact('items', 'count'));
    }

    public function confirmResendPassword($id)
    {
        $this->confirmingResendId = $id;
    }

    public function resendPassword()
    {
        $admin = Employee::findOrFail($this->confirmingResendId);

        if ($admin->is_system) {
            abort(403);
        }
        $plainPassword = Str::password(12);
        $admin->update([
            'password' => Hash::make($plainPassword),
        ]);
        $admin->notify(new AdminWelcomeNotification($plainPassword));
        $this->confirmingResendId = null;
        session()->flash('success', __('New credentials sent successfully.'));
    }
}
