<div class="hs-tooltip inline-block">
    <a
        href="{{ $url }}"
        class="
            group
            inline-flex items-center gap-3
            px-5 py-2.5
            rounded-lg
            bg-white text-slate-700
            border border-slate-200
            shadow-sm
            hover:bg-slate-50 hover:shadow-md
            transition
        "
    >
        {{-- icon container --}}
        <span
            class="
                flex items-center justify-center
                w-7 h-7
                rounded-full
                bg-slate-100
                text-slate-600
                transition
                group-hover:bg-slate-200
            "
        >
            <i class="material-symbols-rounded text-[18px] leading-none">
                arrow_back
            </i>
        </span>

        <span class="text-sm font-medium whitespace-nowrap">
            {{ __('Back to list') }}
        </span>
    </a>

    {{-- Tooltip --}}
    <span
        class="
            hs-tooltip-content
            hs-tooltip-shown:opacity-100
            hs-tooltip-shown:visible
            opacity-0 invisible
            transition-opacity
            inline-block absolute z-10
            py-1.5 px-2.5
            bg-gray-900
            text-xs font-medium text-white
            rounded-md
            shadow-sm
        "
        role="tooltip"
    >
        {{ __('Back to list') }}
    </span>
</div>
