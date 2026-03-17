@can('admin.stores')
<li>
    <a href="{{ route('admin.stores') }}"
       class="{{ $baseItem }} {{ request()->routeIs('admin.stores') ? $activeItem : '' }}">
        <i class="material-symbols-rounded text-xl">store</i>
        <span>{{ __('Stores') }}</span>
    </a>
</li>
@endcan
