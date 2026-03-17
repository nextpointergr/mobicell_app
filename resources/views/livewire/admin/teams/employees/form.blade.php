<div>
    @include('livewire.admin._partials.form-header', [
        'id' => $id,
        'title' => $name,
        'editTitle' => __('Edit Employee'),
        'createTitle' => __('Add a Employee'),
        'badge' => $name,
        'backUrl' => route('admin.employees'),
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
                            <x-input-label for="email" :value="__('Email')" required="true"></x-input-label>
                            <x-text-input wire:model="email" id="email" placeholder="{{__('Email')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            @if($id && $employee?->is_system)
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ __('System employee role cannot be changed.') }}
                                </p>
                            @else
                                 <x-input-label for="id_role" :value="__('Select Role')" required="true"></x-input-label>
                                <select wire:model="id_role"  class="form-select" id="role">
                                    <option selected="" value="">{{ __('Select a Role') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $id_role ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('id_role')" />
                            @endif
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-1 gap-6 mt-5">
                        <x-form-actions
                            :id="$id"
                            :back-url="route('admin.employees')"
                            :disabled="false"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
