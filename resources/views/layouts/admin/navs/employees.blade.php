@canany(['admin.employees', 'admin.roles', 'admin.permissions'])

    @php
        $teamsOpen = request()->routeIs(
            'admin.employees*',
            'admin.roles*',
            'admin.permissions*'
        );
    @endphp

    <li class="menu-item">

        {{-- TOGGLE --}}
        <button type="button"
                onclick="this.nextElementSibling.classList.toggle('hidden')"
                class="flex items-center w-full gap-3
                   px-4 py-2.5 rounded-lg text-sm
                   text-slate-700 transition
                   hover:bg-slate-100
                   {{ $teamsOpen ? 'bg-slate-100 font-medium' : '' }}">

            <i class="material-symbols-rounded text-xl">groups</i>
            <span>{{ __('Teams') }}</span>

            <i class="material-symbols-rounded ms-auto text-base transition
            {{ $teamsOpen ? 'rotate-90' : '' }}">
                chevron_right
            </i>
        </button>

        {{-- CONTENT --}}
        <div class="mt-1 space-y-1 {{ $teamsOpen ? '' : 'hidden' }}">

            {{-- EMPLOYEES --}}
            @can('admin.employees')
                <a href="{{ route('admin.employees') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.employees*') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('Employees') }}
                </a>
            @endcan

            {{-- ROLES --}}
            @can('admin.roles')
                <a href="{{ route('admin.roles') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.roles*') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('Roles') }}
                </a>
            @endcan

            {{-- PERMISSIONS --}}
            @can('admin.permissions')
                <a href="{{ route('admin.permissions') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.permissions*') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('Permissions') }}
                </a>
            @endcan

        </div>
    </li>

@endcanany
