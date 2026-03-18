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


    public function checkErpConnection($id)
    {
        try {

            $store = \App\Models\Store::where('id', $id)->firstOrFail();


            if (!$store->hasPylon()) {
                $this->dispatch('notify', type: 'error', message: 'Το κατάστημα δεν έχει ρυθμιστεί με ERP στοιχεία.');
                return;
            }

            // ✔ check connection (login test)
            $isConnected = Pylon::store($store->slug)
                ->client()
                ->check();




            if (!$isConnected) {
                $this->dispatch('notify', type: 'error', message: 'Αποτυχία σύνδεσης με το ERP.');
                return;
            }



            $this->dispatch('notify', type: 'success', message: 'Επιτυχής σύνδεση με το ERP.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            $this->dispatch('notify', type: 'error', message: 'Το κατάστημα δεν βρέθηκε.');

        } catch (\NextPointer\Pylon\Exceptions\AuthenticationException $e) {

            $this->dispatch('notify', type: 'error', message: 'Λάθος στοιχεία σύνδεσης ERP.');

        } catch (\NextPointer\Pylon\Exceptions\HttpException $e) {

            $this->dispatch('notify', type: 'error', message: 'Σφάλμα επικοινωνίας με τον ERP server.');

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            $this->dispatch('notify', type: 'error', message: 'Απρόσμενο σφάλμα κατά τη σύνδεση με το ERP.');
        }
    }


    public function toggleActive($id)
    {
        try {

            $store = Store::findOrFail($id);

            $store->update([
                'active' => !$store->active
            ]);

            $this->dispatch(
                'notify',
                type: 'success',
                message: $store->active
                    ? 'Το κατάστημα ενεργοποιήθηκε.'
                    : 'Το κατάστημα απενεργοποιήθηκε.'
            );

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            $this->dispatch(
                'notify',
                type: 'error',
                message: 'Αποτυχία ενημέρωσης κατάστασης.'
            );
        }
    }
}
