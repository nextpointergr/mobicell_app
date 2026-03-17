<?php

namespace App\Livewire\Admin\Settings\Interface;
use App\Livewire\Admin\AComponent;
use App\Models\Setting;


class Index extends AComponent
{

    public string $activeTab = 'interface';
    public $admin_panel_list_pagination_number;
    public $warehouse_id_erp;
    protected array $rules = [
        'admin_panel_list_pagination_number' => 'required|integer|min:1',
        'warehouse_id_erp' => 'required|integer',
    ];

    public function mount()
    {
        $this->admin_panel_list_pagination_number       = Setting::get('admin_panel_list_pagination_number','');
        $this->warehouse_id_erp = Setting::get('warehouse_id_erp','');

    }
    public function render()
    {
        return view('livewire.admin.settings.interface.index');
    }

    public function save()
    {
        $this->validate();
        Setting::set('admin_panel_list_pagination_number', $this->admin_panel_list_pagination_number);
        Setting::set('warehouse_id_erp', $this->warehouse_id_erp);
        session()->flash('success',  __('Your changes have been saved.'));
        return redirect()->route('admin.settings.interfaces');
    }


}
