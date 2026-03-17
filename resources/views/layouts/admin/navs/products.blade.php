


@php
    $productsOpen = request()->routeIs('admin.products*');
    // Ιδανικά αυτό το count θα έρχεται από ένα View Composer,
    // αλλά για το παράδειγμα το βάζουμε εδώ:

    $pendingCount = \App\Models\Product::pendingReview()->count();

@endphp

<li class="menu-item">
    {{-- TOGGLE --}}
    <button type="button"
            onclick="this.nextElementSibling.classList.toggle('hidden')"
            class="flex items-center w-full gap-3
                   px-4 py-2.5 rounded-lg text-sm
                   text-slate-700 transition
                   hover:bg-slate-100
                   {{ $productsOpen ? 'bg-slate-100 font-medium' : '' }}">

        <i class="material-symbols-rounded text-xl">inventory_2</i>
        <span>{{ __('Products') }}</span>

        <i class="material-symbols-rounded ms-auto text-base transition
            {{ $productsOpen ? 'rotate-90' : '' }}">
            chevron_right
        </i>
    </button>

    <div class="mt-1 space-y-1 {{ $productsOpen ? '' : 'hidden' }}">

        {{-- GENERAL --}}
        @can('admin.products')
            <a href="{{ route('admin.products') }}"
               class="flex items-center w-full
                      ps-12 pe-4 py-2.5 rounded-lg text-sm
                      text-slate-600 transition
                      hover:bg-slate-100
                      {{ request()->routeIs('admin.products') ? 'bg-slate-100 font-medium' : '' }}">

                {{ __('All products') }}
            </a>
        @endcan

        @if($pendingCount > 0)
            <a href="{{ route('admin.products', ['filter' => 'missing_stock']) }}"
               class="flex items-center w-full ps-12 pe-4 py-2 rounded-lg text-sm text-red-500 hover:bg-red-50 {{ request()->fullUrlIs('*missing_stock*') ? 'bg-red-50 font-bold' : '' }}">
                {{ __('Missing Stock') }}
            </a>
        @endif
    </div>
</li>
