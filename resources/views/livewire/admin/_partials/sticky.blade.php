<div
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 300)"
    :class="show ? 'translate-y-0 opacity-100' : 'translate-y-20 opacity-0'"
    class="
        fixed bottom-4 right-4
        z-50
        transition-all duration-500 ease-out
    "
>
    <div
        class="
            flex items-center gap-2
            bg-white
            border border-gray-200
            rounded-2xl
            shadow-xl
            p-2
        "
    >
        {{-- Primary --}}
        <a
            href="#"
            class="
                flex items-center gap-2
                bg-orange-500 hover:bg-orange-600
                text-white text-sm font-medium
                px-4 py-2
                rounded-xl
                transition whitespace-nowrap
            "
        >
            <i class="material-symbols-rounded text-base">play_arrow</i>
            Start now
        </a>

        {{-- Secondary --}}
        <a
            href="#"
            class="
                flex items-center gap-2
                bg-slate-900 hover:bg-slate-800
                text-white text-sm font-medium
                px-4 py-2
                rounded-xl
                transition whitespace-nowrap
            "
        >
            <i class="material-symbols-rounded text-base">link</i>
            Short link
        </a>

        {{-- Icon only --}}
        <button
            class="
                flex items-center justify-center
                w-10 h-10
                bg-gray-100 hover:bg-gray-200
                rounded-xl
                transition
            "
            title="QR Code"
        >
            <i class="material-symbols-rounded text-lg">qr_code</i>
        </button>
    </div>
</div>
