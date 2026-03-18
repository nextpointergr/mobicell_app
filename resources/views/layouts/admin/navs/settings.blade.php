<li class="list-none group" x-data="{ open: {{ request()->routeIs('admin.settings*') ? 'true' : 'false' }} }">
    <button @click="open = !open"
            class="flex items-center gap-4 w-full px-4 py-2.5 rounded-xl transition-all duration-300
            {{ request()->routeIs('admin.settings*') ? 'text-slate-900' : 'text-slate-500 hover:bg-slate-50' }}">

        <i class="ti ti-settings text-[20px] transition-colors
        {{ request()->routeIs('admin.settings*') ? 'text-[#c02228]' : 'text-slate-300 group-hover:text-slate-500' }}"></i>

        <span class="flex-1 text-left font-bold text-[14px] tracking-tight">{{ __('Ρυθμίσεις') }}</span>

        <i class="ti ti-chevron-right text-[12px] transition-transform duration-300"
           :class="open ? 'rotate-90 text-[#c02228]' : 'text-slate-300'"></i>
    </button>


    <div x-show="open" x-collapse x-cloak class="mt-1 ml-3 pl-4 border-l border-slate-100 space-y-0.5">
        @php
            $subStyle = "block py-2 px-4 text-[13px] font-bold transition-all rounded-lg ";
            $activeSub = "text-[#c02228] bg-red-50/30 relative before:absolute before:left-[-17px] before:top-2 before:bottom-2 before:w-[2px] before:bg-[#c02228]";
            $inactiveSub = "text-slate-400 hover:text-slate-700 hover:bg-slate-50";
        @endphp

        <a href="{{ route('admin.settings.info') }}"
           class="{{ $subStyle }} {{ request()->routeIs('admin.settings.info') ? $activeSub : $inactiveSub }}">
            {{ __('My profile') }}
        </a>

        @can('admin.settings.general')
            <a href="{{ route('admin.settings.general') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.settings.general') ? $activeSub : $inactiveSub }}">
                {{ __('General') }}
            </a>
        @endcan

        {{-- SMTP --}}
        @can('admin.settings.smtp')

            <a href="{{ route('admin.settings.smtp') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.settings.smtp') ? $activeSub : $inactiveSub }}">
                {{ __('SMTP') }}
            </a>
        @endcan

        {{-- API TOKENS --}}
        @can('admin.settings.api_token')

            <a href="{{ route('admin.settings.api_token') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.settings.api_token') ? $activeSub : $inactiveSub }}">
                {{ __('API Tokens') }}
            </a>
        @endcan


        {{-- PERFORMANCE --}}
        @can('admin.settings.performance')


            <a href="{{ route('admin.settings.performance') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.settings.performance') ? $activeSub : $inactiveSub }}">
                {{ __('Performance') }}
            </a>
        @endcan

    </div>
</li>
