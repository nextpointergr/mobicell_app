@props([
    'disabled' => false,
])

<div>
    <button
        type="submit"
        @if($disabled) disabled @endif
        class="
            inline-flex items-center gap-3
            rounded-2xl
            px-8 py-4
            text-sm font-semibold
            shadow-lg
            transition
            focus:outline-none
            focus:ring-2 focus:ring-offset-2

            {{ $disabled
                ? 'bg-gray-300 text-gray-500 cursor-not-allowed shadow-none'
                : 'bg-indigo-600 text-white hover:bg-indigo-700 hover:shadow-xl active:scale-[0.98] focus:ring-indigo-500'
            }}
        "
    >

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="1.8"
             stroke-linecap="round"
             stroke-linejoin="round"
             class="h-5 w-5">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
        </svg>

        {{ __('Save changes') }}
    </button>
</div>
