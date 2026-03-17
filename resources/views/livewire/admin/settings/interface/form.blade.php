<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <x-input-label for="admin_panel_list_pagination_number" :value="__('Items per page')" required="true"></x-input-label>
            <x-text-input wire:model="admin_panel_list_pagination_number" id="admin_panel_list_pagination_number"
                          placeholder="{{__('Enter number of items per page')}}"
                          type="number" class="mt-1 block w-full" min="1" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('admin_panel_list_pagination_number')" />
        </div><!-- div-->
        @if($this->warehouses->count())
        {{-- ERP Warehouse --}}
        <div>
            <x-input-label
                for="warehouse_id_erp"
                :value="__('ERP Warehouse')"
                required="true"
            />

            <select
                wire:model="warehouse_id_erp"
                id="warehouse_id_erp"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            >
                <option value="">-- {{ __('Select Warehouse') }} --</option>

                @foreach($this->warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>

            <x-input-error
                class="text-red-500 text-xs font-medium"
                :messages="$errors->get('warehouse_id_erp')"
            />
        </div>


        @endif

    </div>
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <x-button-setting-save />
    </div>
</form>
