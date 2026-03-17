
<aside id="app-menu"
       class="hs-overlay fixed inset-y-0 start-0 z-[60] hidden w-64 -translate-x-full transform overflow-y-auto
         bg-white transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0
          lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full
          rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true]
          [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">

    <div class="sticky top-0 flex h-16 items-center justify-center px-6">
                <a href="{{route('admin.dashboard')}}" class="flex">
                    <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="flex h-10">

                </a>
    </div>
    <div class="hs-accordion-group h-[calc(100%-72px)] p-4 ps-0" data-simplebar>

        @php
            $baseItem = '
            flex items-center gap-3 w-full
            px-4 py-2.5 rounded-lg text-sm
            transition
            text-slate-700
            hover:bg-slate-100
            ';
            $activeItem = 'bg-slate-100 font-medium';
        @endphp
        <ul class="admin-menu flex w-full flex-col gap-1.5">
            @include('layouts.admin.navs.dashboard')
            @include('layouts.admin.navs.stores')
            @include('layouts.admin.navs.employees')
            @include('layouts.admin.navs.system')
            @include('layouts.admin.navs.settings')
        </ul><!-- admin-menu flex w-full flex-col gap-1.5-->
    </div><!-- hs-accordion-group h-[calc(100%-72px)] p-4 ps-0-->
</aside><!-- app-menu-->





