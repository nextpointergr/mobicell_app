<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <x-input-label for="admin_panel_list_pagination_number" :value="__('Items per page')" required="true"></x-input-label>
            <x-text-input wire:model="admin_panel_list_pagination_number" id="admin_panel_list_pagination_number"
                          placeholder="{{__('Enter number of items per page')}}"
                          type="number" class="mt-1 block w-full" min="1" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('admin_panel_list_pagination_number')" />
        </div><!-- div-->


    </div>
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <x-button-setting-save />
    </div>
</form>
