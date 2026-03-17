@props([
    'id' => null,
    'backUrl',
    'disabled' => false,
])

{{-- FORM FOOTER --}}
<div class="mt-8 pt-6 border-t border-slate-200 flex items-center gap-4  form-actions">

    {{-- LEFT ACTIONS --}}
    <div class="flex items-center gap-4 form-actions-buttons">

        @if(!$id)
            {{-- Save & add new --}}
            <div class=" inline-block">
                <button
                    type="button"
                    wire:click="save('stay')"
                    @disabled($disabled)
                    class="
                        inline-flex items-center gap-2
                        px-6 py-3
                        rounded-lg
                        text-sm font-semibold
                        text-slate-700
                        bg-white
                        border border-slate-300
                        shadow-sm
                        transition
                        {{ $disabled
                            ? 'opacity-50 cursor-not-allowed'
                            : 'hover:bg-slate-50 hover:shadow-md'
                        }}
                    "
                >
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4a8 8 0 100 16 8 8 0 000-16z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8v8m4-4H8"/>
                    </svg>

                    {{ __('Save & add new') }}
                </button>


            </div>
        @endif

        {{-- Save --}}
        <div class="inline-block">
            <button
                type="button"
                wire:click="save('list')"
                @disabled($disabled)
                class="
                    inline-flex items-center gap-2
                    px-7 py-3
                    rounded-lg
                    text-sm font-semibold
                    shadow-md
                    transition
                    {{ $disabled
                        ? 'bg-slate-400 text-white opacity-50 cursor-not-allowed'
                        : 'bg-slate-900 text-white hover:bg-slate-800 hover:shadow-lg'
                    }}
                "
            >
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.8"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4a8 8 0 100 16 8 8 0 000-16z"/>
                </svg>

                {{ __('Save') }}
            </button>


        </div>
            {{-- RIGHT / CANCEL (ΠΟΤΕ disabled) --}}
            <div class="inline-block">
                <a
                    href="{{ $backUrl }}"
                    class="
                inline-flex items-center gap-2
                px-5 py-3
                rounded-lg
                text-sm font-medium
                text-red-600
                bg-red-50
                border border-red-200
                shadow-sm
                hover:bg-red-100 hover:shadow-md
                transition
            "
                >
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 9l-6 6m0-6l6 6"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4a8 8 0 100 16 8 8 0 000-16z"/>
                    </svg>

                    {{ __('Cancel') }}
                </a>

            </div>
    </div>


</div>
