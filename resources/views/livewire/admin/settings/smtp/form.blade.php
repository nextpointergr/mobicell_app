<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-4 gap-6">

        <div>
            <x-input-label for="mail_mailer" :value="__('Mailer')" required="true"></x-input-label>
            <x-text-input wire:model="mail_mailer" id="mail_mailer" placeholder="{{__('Mailer')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('mail_mailer')" />
        </div><!-- div-->


        <div>
            <x-input-label for="mail_host" :value="__('SMTP Host')" required="true"></x-input-label>
            <x-text-input wire:model="mail_host" id="mail_host" placeholder="{{__('SMTP Host')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('mail_host')" />

        </div><!-- div-->




        <div>
            <x-input-label for="mail_port" :value="__('SMTP Port')" required="true"></x-input-label>
            <x-text-input wire:model="mail_port" id="mail_port" placeholder="{{__('SMTP Port')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_port')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_username" :value="__('SMTP Username')" required="true"></x-input-label>
            <x-text-input wire:model="mail_username" id="mail_username" placeholder="{{__('SMTP Username')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_username')" />
        </div><!-- div-->


    </div>

    <div class="grid lg:grid-cols-4 gap-6 mt-5">
        <div>
            <x-input-label for="mail_password" :value="__('SMTP Password')" required="true"></x-input-label>
            <x-text-input wire:model="mail_password" id="mail_password" placeholder="{{__('SMTP Password')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_password')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_encryption" :value="__('Encryption (tls/ssl)')" required="true"></x-input-label>
            <x-text-input wire:model="mail_encryption" id="mail_encryption" placeholder="{{__('Encryption (tls/ssl)')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_encryption')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_from_address" :value="__('From Email')" required="true"></x-input-label>
            <x-text-input wire:model="mail_from_address" id="mail_from_address" placeholder="{{__('From Email')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_from_address')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_from_name" :value="__('From Name')" required="true"></x-input-label>
            <x-text-input wire:model="mail_from_name" id="mail_from_name" placeholder="{{__('From Name')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_from_name')" />
        </div><!-- div-->



    </div>



        <div class="grid lg:grid-cols-2 gap-6 mt-5" style="margin-top: 50px;">
            <x-button-setting-save />



            @if($mail_mailer && $mail_host && $mail_username && $mail_password && $mail_encryption && $mail_from_address  && $mail_from_name)
                <div class="grid lg:grid-cols-2 gap-5">
                    <div>
                        <x-text-input wire:model="test_email" id="test_email"
                                      placeholder="{{__('Test email')}}"
                                      type="text" class=" block w-full"
                                      style="height: 100%"
                        />
                        <x-input-error class="text-red-500 text-xs font-medium"
                                       :messages="$errors->get('test_email')"/>
                    </div> <!-- div -->
                    <div>
                        <button
                            style="height: 100%;width: 100%"
                            wire:click="sendTestEmail"
                            wire:loading.attr="disabled"
                            wire:target="sendTestEmail"
                            type="button"
                            class="
        btn bg-primary/25 text-primary
        hover:bg-primary hover:text-white
        disabled:opacity-60 disabled:cursor-not-allowed
        flex items-center justify-center gap-2
    "
                        >
                            {{-- NORMAL --}}
                            <span wire:loading.remove wire:target="sendTestEmail" class="flex items-center gap-2">
        <i class="material-symbols-rounded font-light text-2xl">send</i>
        {{ __('Send Test Email') }}
    </span>

                            {{-- LOADING --}}
                            <span wire:loading wire:target="sendTestEmail" class="flex items-center gap-2">
        <svg class="animate-spin h-5 w-5 text-primary"
             xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"/>
        </svg>

        {{ __('Sending...') }}
    </span>
                        </button>
                    </div> <!-- div -->
                </div><!-- grid lg:grid-cols-2 gap-5-->

            @endif
        </div>











</form>

@if(smtpConfigReady())
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 mt-10">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-green-600 text-white flex items-center justify-center">
                ✓
            </div>
            <div>
                <p class="text-sm font-semibold text-green-900">
                    {{ __('SMTP configuration is active') }}
                </p>
                <p class="text-xs text-green-700">
                    {{ __('Emails will be sent using the configured SMTP settings.') }}
                </p>
            </div>
        </div>
    </div>
@else
    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4 mt-10">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-amber-500 text-white flex items-center justify-center">
                !
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-900">
                    {{ __('SMTP is not validated') }}
                </p>
                <p class="text-xs text-amber-700">
                    {{ __('Please send a test email to activate the SMTP configuration.') }}
                </p>
            </div>
        </div>
    </div>
@endif


