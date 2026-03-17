@canany([
    'admin.system.logs',
    'admin.system.jobs'
])

    @php
        $systemOpen = request()->routeIs('admin.system.*');
    @endphp

    <li class="menu-item">

        {{-- TOGGLE --}}
        <button type="button"
                onclick="this.nextElementSibling.classList.toggle('hidden')"
                class="flex items-center w-full gap-3
                   px-4 py-2.5 rounded-lg text-sm
                   text-slate-700 transition
                   hover:bg-slate-100
                   {{ $systemOpen ? 'bg-slate-100 font-medium' : '' }}">

            <i class="material-symbols-rounded text-xl">dns</i>
            <span>{{ __('System') }}</span>

            <i class="material-symbols-rounded ms-auto text-base transition
            {{ $systemOpen ? 'rotate-90' : '' }}">
                chevron_right
            </i>
        </button>

        {{-- CONTENT --}}
        <div class="mt-1 space-y-1 {{ $systemOpen ? '' : 'hidden' }}">

            {{-- AUDIT LOGS --}}
            @can('admin.system.logs')
                <a href="{{ route('admin.system.logs') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.system.logs') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('Audit Logs') }}
                </a>
            @endcan


            {{-- AUDIT LOGS --}}
            @can('admin.system.jobs')
                <a href="{{ route('admin.system.jobs') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.system.jobs') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('Cron Jobs') }}
                </a>
            @endcan


        </div>
    </li>

@endcanany
