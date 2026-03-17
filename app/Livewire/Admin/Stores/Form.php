<?php

namespace App\Livewire\Admin\Stores;

use App\Livewire\Admin\AComponent;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Form extends AComponent
{
    public $id;
    public $name;
    public $slug;
    public $email;
    public $phone;
    public $address;
    public $active = true;
    public $central = false;

    // 🔥 PYLON
    public $pylon_base_url;
    public $pylon_apicode;
    public $pylon_databasealias;
    public $pylon_username;
    public $pylon_password;
    public $pylon_applicationname;

    public $isEdit = false;

    public Store $store;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stores', 'slug')->ignore($this->id),
            ],

            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',

            'active' => 'boolean',
            'central' => 'boolean',

            // 🔥 PYLON VALIDATION
            'pylon_base_url' => 'nullable|string|max:255',
            'pylon_apicode' => 'nullable|string|max:255',
            'pylon_databasealias' => 'nullable|string|max:255',
            'pylon_username' => 'nullable|string|max:255',
            'pylon_password' => $this->isEdit ? 'nullable|string|max:255' : 'nullable|string|max:255',
            'pylon_applicationname' => 'nullable|string|max:255',
        ];
    }

    public function mount(?Store $store = null)
    {
        if ($store) {
            $this->store   = $store;
            $this->id      = $store->id;
            $this->name    = $store->name;
            $this->slug    = $store->slug;
            $this->email   = $store->email;
            $this->phone   = $store->phone;
            $this->address = $store->address;
            $this->active  = $store->active;
            $this->central = $store->central;

            // 🔥 PYLON
            $this->pylon_base_url = $store->pylon_base_url;
            $this->pylon_apicode = $store->pylon_apicode;
            $this->pylon_databasealias = $store->pylon_databasealias;
            $this->pylon_username = $store->pylon_username;
            $this->pylon_applicationname = $store->pylon_applicationname;

            $this->isEdit = true;
        }
    }

    public function updatedName()
    {
        if (!$this->isEdit || empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save($redirect = 'edit')
    {
        $this->validate();

        // 🔥 Ensure only 1 central store
        if ($this->central) {
            Store::where('id', '!=', $this->id)->update(['central' => false]);
        }

        $data = [
            'name'    => $this->name,
            'slug'    => $this->slug,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
            'active'  => $this->active,
            'central' => $this->central,

            // PYLON
            'pylon_base_url' => $this->pylon_base_url,
            'pylon_apicode' => $this->pylon_apicode,
            'pylon_databasealias' => $this->pylon_databasealias,
            'pylon_username' => $this->pylon_username,
            'pylon_applicationname' => $this->pylon_applicationname,
        ];

        // 🔐 password only if filled
        if (!empty($this->pylon_password)) {
            $data['pylon_password'] = $this->pylon_password;
        }

        if ($this->isEdit) {

            $store = Store::findOrFail($this->id);
            $store->update($data);

            $message = __('Store updated successfully.');

        } else {

            $store = Store::create($data);

            $this->id = $store->id;

            $message = __('Store created successfully.');
        }

        if ($redirect === 'list') {
            return redirect()->route('admin.stores')->with('success', $message);
        }

        if ($redirect === 'stay') {
            return redirect()->route('admin.stores.create')->with('success', $message);
        }

        return redirect()
            ->route('admin.stores.edit', $store->id)
            ->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.stores.form');
    }
}
