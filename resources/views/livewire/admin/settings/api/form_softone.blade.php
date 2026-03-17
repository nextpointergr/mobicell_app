<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <x-input-label for="system_api_key" :value="__('Generate API Key')" required="true"></x-input-label>
            <x-text-input wire:model="system_api_key" id="system_api_key" placeholder="{{__('Generate API Key')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('system_api_key')" />
            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>

                    <i>
                        {{ __('This API Key is used by external addons (3rd party addons) to allow other systems to communicate with our software.') }}
                    </i>
                </small>
            </div>
        </div><!-- div-->
    </div>
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <x-button-setting-save />>
    </div>
</form>
