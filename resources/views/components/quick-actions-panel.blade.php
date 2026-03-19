@canany(['admin.shop.sync', 'admin.pylon.sync'])
    <div
        x-data="{
        open: false,
        timeout: null,
        show() {
            clearTimeout(this.timeout);
            this.open = true;
        },
        hide() {
            this.timeout = setTimeout(() => this.open = false, 250);
        }
    }"
        class="fixed right-8 bottom-8 z-50 flex flex-col items-end gap-3"
    >
        <div
            x-cloak
            x-show="open"
            @mouseenter="show()"
            @mouseleave="hide()"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="mb-2 min-w-[240px] bg-white/90 backdrop-blur-xl border border-slate-200/60 rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] p-2.5 overflow-hidden"
        >
            <div class="px-3 py-2 mb-1">
                <span class="text-[10px] font-bold uppercase style tracking-[0.15em] text-indigo-500/80">{{ __('Quick Actions') }}</span>
            </div>


            <div class="my-2 border-t border-slate-100/80 mx-2"></div>
            @can('admin.shop.sync')
                <a href="{{route('admin.shop.sync')}}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all duration-200">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-50 group-hover:bg-white shadow-sm transition-colors border border-slate-100">
                        <i class="material-symbols-rounded text-[20px]">sync</i>
                    </div>
                    <span class="font-semibold">{{ __('Shop Synchronization') }}</span>
                </a>

            @endcan

            @can('admin.pylon.sync')
            <a href="{{route('admin.pylon.sync')}}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-50 group-hover:bg-white shadow-sm transition-colors border border-slate-100">
                    <i class="material-symbols-rounded text-[20px]">cloud_sync</i>
                </div>
                <span class="font-semibold">{{ __('ERP Synchronization') }}</span>
            </a>
            @endcan

            @can('admin.suppliers.sync')
                <a href="{{route('admin.suppliers.sync')}}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-50 group-hover:bg-white shadow-sm transition-colors border border-slate-100">
                        <i class="material-symbols-rounded text-[20px]">cloud_sync</i>
                    </div>
                    <span class="font-semibold">{{ __('Suppliers Synchronization') }}</span>
                </a>
            @endcan
        </div>

        <button
            @mouseenter="show()"
            @mouseleave="hide()"
            @click="open = !open"
            :class="open ? 'rotate-45 bg-slate-800 ring-4 ring-slate-100' : 'bg-indigo-600 shadow-[0_15px_30px_-5px_rgba(79,70,229,0.4)]'"
            class="h-14 w-14 flex items-center justify-center rounded-2xl text-white transition-all duration-500 hover:scale-110 active:scale-95 focus:outline-none"
        >
            <i class="material-symbols-rounded text-3xl">add</i>
        </button>
    </div>
@endcanany
