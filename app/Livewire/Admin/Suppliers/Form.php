<?php

namespace App\Livewire\Admin\Suppliers;

use App\Livewire\Admin\AComponent;
use App\Models\Supplier;
use Livewire\Component;

class Form extends AComponent
{
    public $id;
    public $name;
    public $source_url;
    public $unique_node;
    public $active = true;

    public $isEdit = false;
    public Supplier $supplier;

    protected function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'source_url'  => 'nullable|url',
            'unique_node' => 'nullable|string|max:255',
            'active'      => 'boolean',
        ];
    }

    public function mount(?Supplier $supplier = null)
    {
        if ($supplier) {
            $this->supplier     = $supplier;
            $this->id           = $supplier->id;
            $this->name         = $supplier->name;
            $this->source_url   = $supplier->source_url;
            $this->unique_node  = $supplier->unique_node;
            $this->active       = $supplier->active;
            $this->isEdit       = true;
        }
    }

    public function save($redirect = 'edit')
    {
        $this->validate();

        if ($this->isEdit) {
            $supplier = Supplier::findOrFail($this->id);
            $supplier->update([
                'name'        => $this->name,
                'source_url'  => $this->source_url,
                'unique_node' => $this->unique_node,
                'active'      => $this->active,
            ]);

            $message = __('Supplier updated successfully.');
        } else {
            $supplier = Supplier::create([
                'name'        => $this->name,
                'source_url'  => $this->source_url,
                'unique_node' => $this->unique_node,
                'active'      => $this->active,
            ]);

            $this->id = $supplier->id;
            $message = __('Supplier created successfully.');
        }

        if ($redirect === 'stay') {
            return redirect()
                ->route('admin.suppliers.create')
                ->with('success', $message);
        }

        if ($redirect === 'list') {
            return redirect()
                ->route('admin.suppliers')
                ->with('success', $message);
        }

        return redirect()
            ->route('admin.suppliers.edit', $supplier->id)
            ->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.suppliers.form');
    }
}
