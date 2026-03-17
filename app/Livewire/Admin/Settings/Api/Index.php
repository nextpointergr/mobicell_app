<?php

namespace App\Livewire\Admin\Settings\Api;
use App\Livewire\Admin\AComponent;
use App\Models\Setting;
use Illuminate\Support\Str;

class Index extends AComponent
{

    public string $activeTab = 'api_token';
    public string $system_api_key;

    protected array $rules = [
        'system_api_key' => 'required',
    ];

    public function mount(){
        $this->system_api_key = Setting::get('system_api_key', '');
    }
    public function render()
    {
        return view('livewire.admin.settings.api.index');
    }

    public function save()
    {
        if (empty($this->system_api_key)) {
            $this->system_api_key = Str::uuid()->toString();
        }
        $this->validate();
        Setting::set('system_api_key'   ,  $this->system_api_key);

        session()->flash('success',  __('Your changes have been saved.'));
        return redirect()->route('admin.settings.api_token');
    }

}
