<div>
    @include('livewire.admin._partials.form-header', [
        'id' => $id,
        'title' => $name,
        'editTitle' => __('Edit Store'),
        'createTitle' => __('Add Store'),
        'badge' => $name,
        'backUrl' => route('admin.stores'),
    ])

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">

                @include('livewire.admin._partials.messages.success')
                @include('livewire.admin._partials.messages.error')

                <form wire:submit.prevent="save" class="mt-5">

                    {{-- BASIC INFO --}}
                    <div class="grid lg:grid-cols-2 gap-6">

                        <div>
                            <x-input-label for="name" :value="__('Name')" required="true"/>
                            <x-text-input wire:model="name" id="name" type="text" class="mt-1 w-full"/>
                            <x-input-error :messages="$errors->get('name')" class="text-xs"/>
                        </div>



                        <div>
                            <x-input-label for="email" :value="__('Email')"/>
                            <x-text-input wire:model="email" id="email" type="text" class="mt-1 w-full"/>
                            <x-input-error :messages="$errors->get('email')" class="text-xs"/>
                        </div>

                    </div>

                    {{-- CONTACT --}}
                    <div class="grid lg:grid-cols-2 gap-6 mt-5">

                        <div>
                            <x-input-label for="phone" :value="__('Phone')"/>
                            <x-text-input wire:model="phone" id="phone" type="text" class="mt-1 w-full"/>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')"/>
                            <x-text-input wire:model="address" id="address" type="text" class="mt-1 w-full"/>
                        </div>

                    </div>



                    {{-- 🔥 PYLON SECTION --}}
                    <div class="mt-8 border-t pt-6">

                        <h3 class="text-sm font-semibold text-gray-700 mb-4">
                            {{ __('Pylon ERP Configuration') }}
                        </h3>

                        <div class="grid lg:grid-cols-3 gap-6">

                            <div>
                                <x-input-label for="pylon_base_url" :value="__('Base URL')"/>
                                <x-text-input wire:model="pylon_base_url" id="pylon_base_url" type="text" class="mt-1 w-full"/>
                            </div>

                            <div>
                                <x-input-label for="pylon_apicode" :value="__('API Code')"/>
                                <x-text-input wire:model="pylon_apicode" id="pylon_apicode" type="text" class="mt-1 w-full"/>
                            </div>

                            <div>
                                <x-input-label for="pylon_databasealias" :value="__('Database Alias')"/>
                                <x-text-input wire:model="pylon_databasealias" id="pylon_databasealias" type="text" class="mt-1 w-full"/>
                            </div>

                            <div>
                                <x-input-label for="pylon_username" :value="__('Username')"/>
                                <x-text-input wire:model="pylon_username" id="pylon_username" type="text" class="mt-1 w-full"/>
                            </div>

                            <div>
                                <x-input-label for="pylon_password" :value="__('Password')"/>
                                <x-text-input wire:model="pylon_password" id="pylon_password" type="password"  class="mt-1 w-full"/>
                            </div>

                            <div>
                                <x-input-label for="pylon_applicationname" :value="__('Application Name')"/>
                                <x-text-input wire:model="pylon_applicationname" id="pylon_applicationname" type="text" class="mt-1 w-full"/>
                            </div>

                        </div>

                        {{-- TEST BUTTON --}}
                        @if($pylon_base_url && $pylon_apicode && $pylon_databasealias && $pylon_username)
                            <div class="mt-4">
                                <button
                                    type="button"
                                    wire:click="$dispatch('erp:check', {{ $id }})"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                                >
                                    {{ __('Test ERP Connection') }}
                                </button>
                            </div>
                        @endif

                    </div>

                    {{-- ACTIONS --}}
                    <div class="grid lg:grid-cols-1 gap-6 mt-6">
                        <x-form-actions
                            :id="$id"
                            :back-url="route('admin.stores')"
                            :disabled="false"
                        />
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
