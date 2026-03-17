<form wire:submit.prevent="save" class="mt-5">

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- NAME --}}
        <div>
            <x-input-label for="name" :value="__('Full Name')" required="true"></x-input-label>

            <x-text-input
                wire:model="name"
                id="name"
                type="text"
                placeholder="{{ __('Full Name') }}"
                class="mt-1 block w-full" />

            <x-input-error class="text-red-500 text-xs font-medium"
                           :messages="$errors->get('name')" />

        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" required="true"></x-input-label>

            <x-text-input
                wire:model="email"
                id="email"
                type="email"
                placeholder="{{ __('Email Address') }}"
                class="mt-1 block w-full" />

            <x-input-error class="text-red-500 text-xs font-medium"
                           :messages="$errors->get('email')" />

        </div>


        <div>
            <x-input-label for="password" :value="__('New Password')"></x-input-label>

            <x-text-input
                wire:model="password"
                id="password"
                type="password"
                autocomplete="new-password"

                placeholder="{{ __('Leave blank to keep current password') }}"
                class="mt-1 block w-full" />

            <x-input-error class="text-red-500 text-xs font-medium"
                           :messages="$errors->get('password')" />

        </div>

    </div>



    {{-- SAVE BUTTON --}}
    <div class="grid lg:grid-cols-3 gap-6 mt-6">
        <x-button-setting-save />
    </div>

</form>
