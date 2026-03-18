<?php

namespace App\Livewire\Admin\Global;

use App\Livewire\Admin\AComponent;
use App\Services\ErpConfigurationService;
use Livewire\Component;

class ErpConfigurationAlert extends AComponent
{

    public array $erpConfig = [];

    public function mount(ErpConfigurationService $service)
    {
        $this->erpConfig = $service->check();
    }

    /*
    |--------------------------------------------------------------------------
    | Optional refresh (αν αλλάξεις store config)
    |--------------------------------------------------------------------------
    */

    protected $listeners = ['erp:refresh' => 'refreshStatus'];

    public function refreshStatus(ErpConfigurationService $service)
    {
        $this->erpConfig = $service->check();
    }

    public function render()
    {
        return view('livewire.admin.global.erp-configuration-alert');
    }
}
