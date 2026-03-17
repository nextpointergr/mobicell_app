@can('admin.orders')
    <li>
        <a href="{{ route('admin.orders') }}"
           class="{{ $baseItem }} {{ request()->routeIs('admin.orders') ? $activeItem : '' }}">
            <i class="material-symbols-rounded text-xl">receipt_long</i>
            <span>{{ __('Orders') }}</span>
        </a>
    </li>
@endcan
