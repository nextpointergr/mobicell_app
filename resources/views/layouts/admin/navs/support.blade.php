@php
    $devItem = '
    flex items-center gap-3 w-full
    px-4 py-2.5 rounded-lg text-sm
    transition
    text-amber-700
    bg-amber-50
    hover:bg-amber-100
    ';
@endphp

<li>
    <a href="{{ route('admin.support') }}"
       class="{{ $devItem }} {{ request()->routeIs('admin.support') ? 'ring-2 ring-amber-400 font-semibold' : '' }}">
        <i class="material-symbols-rounded text-xl">support</i>
        <span>{{ __('Support (DEV)') }}</span>
    </a>
</li>
