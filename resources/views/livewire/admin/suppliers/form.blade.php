<div>
    @include('livewire.admin._partials.form-header', [
        'id' => $id,
        'title' => $name,
        'editTitle' => __('Edit supplier'),
        'createTitle' => __('Add a supplier'),
        'badge' => $name,
        'backUrl' => route('admin.suppliers'),
        ])

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">
                @include('livewire.admin._partials.messages.success')
                @include('livewire.admin._partials.messages.error')
                <form wire:submit.prevent="save" class="mt-5">
                    <div class="grid lg:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" required="true"></x-input-label>
                            <x-text-input wire:model="name" id="name" placeholder="{{__('Name')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Source URL')" required="true"></x-input-label>
                            <x-text-input wire:model="source_url" id="email" placeholder="{{__('Source URL')}}" type="text"
                                          class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('source_url')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Unique node')" required="true"></x-input-label>
                            <x-text-input wire:model="unique_node" id="email" placeholder="{{__('Unique node')}}" type="text"
                                          class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('unique_node')" />
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-1 gap-6 mt-5">
                        <x-form-actions
                            :id="$id"
                            :back-url="route('admin.suppliers')"
                            :disabled="false"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
