@can('admin.warehouses')
<li>
    <a href="{{ route('admin.warehouses') }}"
       class="{{ $baseItem }} {{ request()->routeIs('admin.warehouses') ? $activeItem : '' }}">
        <i class="material-symbols-rounded text-xl">warehouse</i>
        <span>{{ __('Warehouses') }}</span>
    </a>
</li>
@endcan
