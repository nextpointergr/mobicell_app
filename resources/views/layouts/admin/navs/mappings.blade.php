

@php
    $settingsOpen = request()->routeIs('admin.mappings*');
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
        <span>{{ __('Mappings') }}</span>

        <i class="material-symbols-rounded ms-auto text-base transition
            {{ $settingsOpen ? 'rotate-90' : '' }}">
            chevron_right
        </i>
    </button>

    {{-- CONTENT --}}
    <div class="mt-1 space-y-1 {{ $settingsOpen ? '' : 'hidden' }}">







        {{-- Categories --}}
        @can('admin.mappings.categories')
            <a href="{{ route('admin.mappings.categories') }}"
               class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.mappings.categories') ? 'bg-slate-100 font-medium' : '' }}">
                {{ __('Categories') }}
            </a>
        @endcan

        {{-- Taxes --}}
        @can('admin.mappings.taxes')
            <a href="{{ route('admin.mappings.taxes') }}"
               class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.mappings.taxes') ? 'bg-slate-100 font-medium' : '' }}">
                {{ __('Taxes') }}
            </a>
        @endcan

        {{-- Carriers --}}
        @can('admin.mappings.carriers')
            <a href="{{ route('admin.mappings.carriers') }}"
               class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.mappings.carriers') ? 'bg-slate-100 font-medium' : '' }}">
                {{ __('Carriers') }}
            </a>
        @endcan

        {{-- Payments --}}
        @can('admin.mappings.payments')
            <a href="{{ route('admin.mappings.payments') }}"
               class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.mappings.payments') ? 'bg-slate-100 font-medium' : '' }}">
                {{ __('Payments') }}
            </a>
        @endcan





    </div>
</li>

