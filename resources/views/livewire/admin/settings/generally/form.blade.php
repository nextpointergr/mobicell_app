<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <x-input-label for="email_notification" :value="__('Email Notification')" required="true"></x-input-label>
            <x-text-input wire:model="email_notification" id="email_notification" placeholder="{{__('Email Notification')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('email_notification')" />
            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('The email you enter here will be used to receive notifications about important system updates, such as synchronizations, price changes, etc.') }}
                    </i>
                </small>
            </div>
        </div><!-- div-->
        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_on_login"  wire:model.defer="notify_on_login">
                <x-input-label class="ms-1.5" for="notify_on_login"
                               :value="__('Notify on every admin login')"></x-input-label>
            </div>
            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to receive an email each time a admin logs into the system.') }}
                    </i>
                </small>
            </div>

        </div>

    </div>

    <div class="grid lg:grid-cols-3 gap-6 mt-5">
            <x-button-setting-save />
    </div>
</form>
