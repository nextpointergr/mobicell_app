@canany(['admin.pylon.categories', 'admin.pylon.payments', 'admin.pylon.shippings'])
    <li class="list-none group" x-data="{ open: {{ request()->routeIs(['admin.pylon.categories', 'admin.pylon.payments', 'admin.pylon.shippings']) ? 'true' : 'false' }} }">
        <button @click="open = !open"
                class="flex items-center gap-4 w-full px-4 py-2.5 rounded-xl transition-all duration-300
            {{ request()->routeIs('admin.pylon.*') ? 'text-slate-900 bg-slate-50/50' : 'text-slate-500 hover:bg-slate-50' }}">

            <i class="ti ti-arrows-split-2 text-[20px] transition-colors
        {{ request()->routeIs(['admin.pylon.categories', 'admin.pylon.payments', 'admin.pylon.shippings']) ? 'text-[#c02228]' : 'text-slate-300 group-hover:text-slate-500' }}"></i>

            <span class="flex-1 text-left font-bold text-[14px] tracking-tight">{{ __('Mapping') }}</span>

            <i class="ti ti-chevron-right text-[12px] transition-transform duration-300"
               :class="open ? 'rotate-90 text-[#c02228]' : 'text-slate-300'"></i>
        </button>

        <div x-show="open" x-collapse x-cloak class="mt-1 ml-3 pl-4 border-l border-slate-100 space-y-0.5">
            @php
                $subStyle = "block py-2 px-4 text-[13px] font-bold transition-all rounded-lg ";
                $activeSub = "text-[#c02228] bg-red-50/30 relative before:absolute before:left-[-17px] before:top-2 before:bottom-2 before:w-[2px] before:bg-[#c02228]";
                $inactiveSub = "text-slate-400 hover:text-slate-700 hover:bg-slate-50";
            @endphp

            @can('admin.pylon.categories')
                <a href="{{ route('admin.pylon.categories') }}"
                   class="{{ $subStyle }} {{ request()->routeIs('admin.pylon.categories*') ? $activeSub : $inactiveSub }}">
                    {{ __('Categories') }}
                </a>
            @endcan

            @can('admin.pylon.payments')
                <a href="{{ route('admin.pylon.payments') }}"
                   class="{{ $subStyle }} {{ request()->routeIs('admin.pylon.payments*') ? $activeSub : $inactiveSub }}">
                    {{ __('Payments') }}
                </a>
            @endcan

            @can('admin.pylon.shippings')
                <a href="{{ route('admin.pylon.shippings') }}"
                   class="{{ $subStyle }} {{ request()->routeIs('admin.pylon.shippings*') ? $activeSub : $inactiveSub }}">
                    {{ __('Shipping') }}
                </a>
            @endcan
        </div>
    </li>
@endcanany
