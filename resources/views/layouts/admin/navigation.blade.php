<aside id="app-menu"
       class="hs-overlay fixed inset-y-0 start-0 z-[60] hidden w-64 -translate-x-full transform overflow-y-auto
         bg-white transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0
          lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full border-r border-slate-100">

    {{-- Logo Section --}}
    <div class="sticky top-0 flex h-24 items-center px-8 bg-white/95 backdrop-blur-md z-10">
        <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3 group">
            <div class="overflow-hidden p-1 transition-transform duration-500 group-hover:scale-110">
                <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="h-9 w-auto">
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-black text-slate-900 tracking-tight leading-none uppercase">{{ __('Business') }}</span>
                <span class="text-[9px] font-bold text-[#c02228] uppercase tracking-[0.2em] mt-1.5 opacity-80">{{ __('Management') }}</span>
            </div>
        </a>
    </div>

    <nav class="px-4 py-2 space-y-8" data-simplebar>
        <div>
            <span class="px-4 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-4 block">{{ __('Central') }}</span>
            <ul class="space-y-1.5"> {{-- Λίγο παραπάνω κενό μεταξύ των li --}}
                @include('layouts.admin.navs.dashboard')
                @include('layouts.admin.navs.stores')
                @include('layouts.admin.navs.employees')
            </ul>
        </div>

        <div class="mt-5">
            <span class="px-4 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-4 block">{{ __('System') }}</span>
            <ul class="space-y-1.5">
                @include('layouts.admin.navs.system')
                @include('layouts.admin.navs.settings')
            </ul>
        </div>
    </nav>

    {{-- Bottom Section --}}
    <div class="absolute bottom-0 w-full p-8 bg-gradient-to-t from-white via-white to-transparent">
        <div class="flex items-center gap-2.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-20"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            {{ __('System Live') }}
        </div>
    </div>
</aside>
