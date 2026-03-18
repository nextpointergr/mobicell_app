<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    {{-- Styles --}}
    @vite([
        'resources/css/app.css',
 'resources/css/new/app.css',
  'resources/css/custom.css',
        'resources/css/icons.css',
    ])


    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Alpine --}}
{{--    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="flex wrapper min-h-screen">

    {{-- Sidebar / Navigation --}}
    @include('layouts.admin.navigation')

    {{-- Page Content --}}
    <div class="flex flex-col flex-1 page-content">

        <header class="sticky top-0 z-50
               h-16 flex items-center px-6
               bg-white/80 backdrop-blur
               border-b border-gray-200">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">
                <button
                    id="button-toggle-menu"
                    class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition"
                    data-hs-overlay="#app-menu"
                    aria-label="Toggle navigation"
                >
                    <i class="ti ti-menu-2 text-2xl"></i>
                </button>
            </div>

            {{-- RIGHT --}}
            <div class="ml-auto flex items-center gap-4">

                @php
                    $admin = Auth::guard('admin')->user();
                @endphp

                <div class="flex items-center gap-4
            px-5 py-3

          mobileVersion">

                    {{-- Avatar --}}
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full
                    bg-indigo-100 text-indigo-600
                    flex items-center justify-center
                    font-semibold text-sm">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>

                        <span class="absolute -bottom-0.5 -right-0.5
                     h-3 w-3 rounded-full
                     bg-green-500 border-2 border-white">
        </span>
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-col leading-tight">

                        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-800">
                {{ $admin->name }}
            </span>

                            <span class="text-[10px] px-2 py-0.5 rounded-full
                         bg-indigo-50 text-indigo-600 font-medium">
                {{ $admin->getRoleNames()->first() }}
            </span>
                        </div>

                        <div class="flex items-center gap-3
                    text-[11px] text-gray-500 mt-1">

            <span>
                {{ __('Last login') }} ·
                <span class="font-medium text-gray-600">
                    {{ $admin->last_login_at
                        ? $admin->last_login_at->diffForHumans()
                        : __('Never') }}
                </span>
            </span>

                            <span class="text-gray-300">•</span>

                            <span class="font-mono text-gray-600">
                {{ $admin->last_login_ip ?? '—' }}
            </span>

                        </div>

                    </div>
                </div>



                {{-- CLEAR CACHE SWITCH --}}
                <div x-data="{ loading: false }">
                    <button
                        type="button"
                        @click="
                    if(confirm('Are you sure you want to clear system cache?')){
                        loading = true;
                        fetch('{{ route('admin.system.run-commands') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                keys: ['cache_clear','config_clear','route_clear','optimize_clear']
                            })
                        }).then(() => {
                            loading = false;
                        });
                    }
                "
                        :class="loading
                    ? 'bg-indigo-600 text-white'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="inline-flex items-center gap-2
                       px-3 py-2
                       rounded-xl
                       text-sm font-medium
                       transition shadow-sm"
                    >
                        <i class="ti ti-refresh text-lg"
                           :class="loading ? 'animate-spin' : ''"></i>

                        <span class="hidden md:inline">
                    Clear Cache
                </span>
                    </button>
                </div>


                {{-- LOGOUT (Modern Ghost Style) --}}
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="group inline-flex items-center gap-2
                       px-3 py-2
                       rounded-xl
                       text-sm font-medium
                       text-gray-600
                       hover:bg-gray-100
                       hover:text-gray-900
                       transition"
                    >
                        <i class="ti ti-logout text-lg
                          group-hover:translate-x-0.5 transition">
                        </i>

                        <span class="hidden md:inline">
                    Logout
                </span>
                    </button>
                </form>

            </div>
        </header>

        {{-- Optional Page Header --}}
        @isset($header)
            <div class="bg-white shadow px-6 py-4">
                {{ $header }}
            </div>
        @endisset

        {{-- Main --}}
        <main class="flex-grow p-6">

            {{ $slot }}





            <livewire:admin.global.erp-checker />


        </main>

        {{-- Footer --}}
        <footer class="h-16 flex items-center px-6 bg-white border-t">
            <div class="flex justify-between w-full text-sm text-gray-600">
                <div>
                    © <script>document.write(new Date().getFullYear())</script> nextpointer.gr
                </div>
                <div class="hidden md:block">
                    {{ __('Development by') }}
                    <a href="https://nextpointer.gr" target="_blank" class="text-primary">
                        nextpointer.gr
                    </a>
                </div>
            </div>
        </footer>





    </div>
</div>

{{-- Scripts --}}
@vite([
    'resources/js/app.js',
    'resources/js/jquery.min.js',
    'resources/js/preline.js',
    'resources/js/simplebar.min.js',
    'resources/js/iconify-icon.min.js',
    'resources/js/quill.min.js'
])

@livewireScripts

@stack('scripts')

<script>


    window.addEventListener('dangerous-actions', e => {
        Swal.fire({
            icon: 'warning',
            title: 'Performance actions',
            text: 'Some actions require a page reload to complete safely.',
            confirmButtonText: 'Relo' +
                'ad & Continue'
        }).then(() => {
            window.location.reload();
        });
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('notify', (data) => {

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data?.type ?? 'success',
                title: data?.message ?? 'Done',
                showConfirmButton: false,
                timer: data?.timer ?? 2200,
                timerProgressBar: true,
            });

        });
    });
</script>
</body>
</html>
