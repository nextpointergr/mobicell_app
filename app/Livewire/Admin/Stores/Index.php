<?php

namespace App\Livewire\Admin\Stores;

use App\Livewire\Admin\AComponent;
use App\Models\Store;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use NextPointer\Pylon\Facades\Pylon;


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
        $query = Store::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            });
        $items = $query->paginate($perPage);
        $count = Store::count();

        return view('livewire.admin.stores.index', [
            'items' => $items,
            'count' => $count,
        ]);
    }


    public function checkErpConnection()
    {



        $result = Pylon::store('elliniko')
            ->items()
            ->all(1, 1)
            ->raw();

        dd($result);


        try {

            $store = \App\Models\Store::where('slug', 'elliniko')->firstOrFail();


            $result = Pylon::store($store)
                ->items()
                ->all(1, 1)
                ->raw();

            dd($result);

            $this->dispatch('notify', type: 'success', message: 'Pylon OK');

        } catch (\Throwable $e) {



            $this->dispatch('notify', type: 'error', message: $e->getMessage());
        }
    }
}
