<?php

namespace App\Livewire\Admin\Global;

use App\Models\Store;
use Livewire\Component;
use NextPointer\Pylon\Facades\Pylon;
use Livewire\Attributes\On;
class ErpChecker extends Component
{

    
    #[On('erp:check')]
    public function check($id)
    {
        try {

            $store = \App\Models\Store::findOrFail($id);

            if (!$store->hasPylon()) {
                $this->dispatch('notify', type: 'error', message: 'Δεν υπάρχουν ERP στοιχεία.');
                return;
            }

            $ok = \NextPointer\Pylon\Facades\Pylon::store($store->slug)
                ->client()
                ->check();

            $this->dispatch(
                'notify',
                type: $ok ? 'success' : 'error',
                message: $ok
                    ? 'Επιτυχής σύνδεση ERP'
                    : 'Αποτυχία σύνδεσης ERP'
            );

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            $this->dispatch('notify', type: 'error', message: 'Σφάλμα σύνδεσης.');
        }
    }
    public function render()
    {
        return view('livewire.admin.global.erp-checker');
    }
}
