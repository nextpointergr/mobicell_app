

    @php
        $settingsOpen = request()->routeIs('admin.settings*');
    @endphp

    <li class="menu-item">

        {{-- TOGGLE --}}
        <button type="button"
                onclick="this.nextElementSibling.classList.toggle('hidden')"
                class="flex items-center w-full gap-3
                   px-4 py-2.5 rounded-lg text-sm
                   text-slate-700 transition
                   hover:bg-slate-100
                   {{ $settingsOpen ? 'bg-slate-100 font-medium' : '' }}">

            <i class="material-symbols-rounded text-xl">tune</i>
            <span>{{ __('Settings') }}</span>

            <i class="material-symbols-rounded ms-auto text-base transition
            {{ $settingsOpen ? 'rotate-90' : '' }}">
                chevron_right
            </i>
        </button>

        {{-- CONTENT --}}
        <div class="mt-1 space-y-1 {{ $settingsOpen ? '' : 'hidden' }}">






            {{-- GENERAL --}}

                <a href="{{ route('admin.settings.info') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.settings.info') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('My profile') }}
                </a>


            {{-- GENERAL --}}
            @can('admin.settings.general')
                <a href="{{ route('admin.settings.general') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.settings.general') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('General') }}
                </a>
            @endcan






            {{-- SMTP --}}
            @can('admin.settings.smtp')
                <a href="{{ route('admin.settings.smtp') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.settings.smtp') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('SMTP') }}
                </a>
            @endcan



            {{-- API TOKENS --}}
            @can('admin.settings.api_token')
                <a href="{{ route('admin.settings.api_token') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.settings.api_token') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('API Tokens') }}
                </a>
            @endcan

            {{-- PERFORMANCE --}}
            @can('admin.settings.performance')
                <a href="{{ route('admin.settings.performance') }}"
                   class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.settings.performance') ? 'bg-slate-100 font-medium' : '' }}">
                    {{ __('Performance') }}
                </a>
            @endcan

        </div>
    </li>

