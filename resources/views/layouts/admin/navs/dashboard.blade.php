<li>
    <a href="{{ route('admin.dashboard') }}"
       class="{{ $baseItem }} {{ request()->routeIs('admin.dashboard') ? $activeItem : '' }}">
        <i class="material-symbols-rounded text-xl">dashboard</i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
