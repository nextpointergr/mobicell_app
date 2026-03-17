<?php

namespace App\Livewire\Admin\Teams\Roles;

use App\Livewire\Admin\AComponent;;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\Role;

class Index extends AComponent
{
    use withPagination;
    use WithoutUrlPagination;

    protected $listeners = [
        'reorderEmployees',
    ];

    public $search;


    public function updatedSearch()
    {
        $this->resetPage();
    }


    public function reorderRoles(array $ids)
    {
        Gate::authorize('admin.roles.sorting');
        foreach ($ids as $index => $id) {
            Role::where('id', $id)->update([
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

        $query = Role::query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('position');

        $items = $query->paginate($perPage);
        $count = Role::count();
        return view('livewire.admin.teams.roles.index', compact('items', 'count'));
    }


}
