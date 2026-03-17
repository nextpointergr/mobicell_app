<div>


    @include('livewire.admin._partials.form-header', [
'id' => $id,
'title' => $name,
'editTitle' => __('Edit role'),
'createTitle' => __('Add a role'),
'badge' => $name,
'backUrl' => route('admin.roles'),
])

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">

                @include('livewire.admin._partials.messages.success')

                <form wire:submit.prevent="save" class="mt-5">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" required="true">

                            </x-input-label>
                            <x-text-input wire:model="name" id="name" placeholder="{{__('Name')}}"
                                          type="text" class="mt-1 block w-full" />
                            @error('name')
                            <span class="text-red-500 text-xs font-medium mt-5">
                                                {{ $message }}
                                            </span>
                            @enderror
                        </div>




                    </div>

                    <div class="grid lg:grid-cols-1 gap-6 mt-5">


                        <x-form-actions
                            :id="$id"
                            :back-url="route('admin.roles')"
                            :disabled="false"
                        />

                    </div><!-- grid lg:grid-cols-1 gap-6 mt-5-->



                </form>

            </div>
        </div>
    </div>

</div>
