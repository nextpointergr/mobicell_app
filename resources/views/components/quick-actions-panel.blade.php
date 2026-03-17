@canany(['admin.warehouses.create',
           'admin.products.create',

           ])

<div
    x-data="{
        open: false,
        timeout: null,
        show() {
            clearTimeout(this.timeout);
            this.open = true;
        },
        hide() {
            this.timeout = setTimeout(() => this.open = false, 150);
        }
    }"
    class="fixed right-6 bottom-24 z-50"
>


    <button
        @mouseenter="show()"
        @mouseleave="hide()"
        @click="open = !open"
        class="h-14 w-14
               bg-indigo-600
               rounded-2xl
               shadow-lg
               flex items-center justify-center
               transition-all duration-200
               hover:bg-indigo-700 hover:scale-105
               focus:outline-none"
    >
        <i class="material-symbols-rounded text-white text-2xl">
            add
        </i>
    </button>

    <div
        x-cloak
        x-show="open"
        @mouseenter="show()"
        @mouseleave="hide()"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="absolute right-16 bottom-0
               w-56
               bg-white
               border border-slate-200
               rounded-2xl
               shadow-2xl
               p-2 origin-bottom-right"
    >



        @can('admin.products.create')
            <a href="{{ route('admin.products.create') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl
                  text-sm text-slate-700 hover:bg-slate-100 transition">
                <i class="material-symbols-rounded text-lg">add_box</i>
                {{ __('Add a product') }}
            </a>
        @endcan
        @can('admin.warehouses.create')
            <a href="{{ route('admin.warehouses.create') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl
                  text-sm text-slate-700 hover:bg-slate-100 transition">
                <i class="material-symbols-rounded text-lg">add</i>
                {{ __('Add a warehouse') }}
            </a>
        @endcan



    </div>
</div>
@endcanany
