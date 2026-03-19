<?php

namespace App\Livewire\Admin\Suppliers;

use App\Livewire\Admin\AComponent;
use App\Models\Store;
use App\Models\Supplier;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends AComponent
{
    use withPagination;
    use WithoutUrlPagination;

    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = $this->search ?? '';
        $perPage = get_system_pagination();
        $query = Supplier::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('source_url', 'like', "%{$search}%");
                });
            });
        $items = $query->paginate($perPage);
        $count = Store::count();

        return view('livewire.admin.suppliers.index', [
            'items' => $items,
            'count' => $count,
        ]);
    }
}
