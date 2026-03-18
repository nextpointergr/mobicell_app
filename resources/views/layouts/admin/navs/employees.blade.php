@canany(['admin.employees', 'admin.roles', 'admin.permissions'])
<li class="list-none group" x-data="{ open: {{ request()->routeIs([ 'admin.employees*',
            'admin.roles*',
            'admin.permissions*']) ? 'true' : 'false' }} }">
    <button @click="open = !open"
            class="flex items-center gap-4 w-full px-4 py-2.5 rounded-xl transition-all duration-300
            {{ request()->routeIs('admin.settings*') ? 'text-slate-900' : 'text-slate-500 hover:bg-slate-50' }}">

        <i class="ti ti-users-group text-[20px] transition-colors
        {{ request()->routeIs('admin.settings*') ? 'text-[#c02228]' : 'text-slate-300 group-hover:text-slate-500' }}"></i>

        <span class="flex-1 text-left font-bold text-[14px] tracking-tight">{{ __('Teams') }}</span>

        <i class="ti ti-chevron-right text-[12px] transition-transform duration-300"
           :class="open ? 'rotate-90 text-[#c02228]' : 'text-slate-300'"></i>
    </button>


    <div x-show="open" x-collapse x-cloak class="mt-1 ml-3 pl-4 border-l border-slate-100 space-y-0.5">
        @php
            $subStyle = "block py-2 px-4 text-[13px] font-bold transition-all rounded-lg ";
            $activeSub = "text-[#c02228] bg-red-50/30 relative before:absolute before:left-[-17px] before:top-2 before:bottom-2 before:w-[2px] before:bg-[#c02228]";
            $inactiveSub = "text-slate-400 hover:text-slate-700 hover:bg-slate-50";
        @endphp

        @can('admin.employees')
            <a href="{{ route('admin.employees') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.employees') ? $activeSub : $inactiveSub }}">
                {{ __('Employees') }}
            </a>
        @endcan

        @can('admin.roles')
            <a href="{{ route('admin.roles') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.roles') ? $activeSub : $inactiveSub }}">
                {{ __('Roles') }}
            </a>
        @endcan

        @can('admin.permissions')
            <a href="{{ route('admin.permissions') }}"
               class="{{ $subStyle }} {{ request()->routeIs('admin.permissions') ? $activeSub : $inactiveSub }}">
                {{ __('Permissions') }}
            </a>
        @endcan
    </div>
</li>


@endcanany
