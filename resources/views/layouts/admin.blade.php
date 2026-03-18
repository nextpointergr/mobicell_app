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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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

        <header class="h-20 flex items-center px-4 md:px-10 bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40">
            @php $admin = Auth::guard('admin')->user(); @endphp

            {{-- Left Section --}}
            <div class="flex items-center gap-3 md:gap-8 flex-1">
                {{-- Burger Menu (Πάντα ορατό σε Mobile) --}}
                <button data-hs-overlay="#app-menu" class="lg:hidden p-2.5 rounded-xl bg-slate-50 text-slate-600 active:scale-95 transition-all">
                    <i class="ti ti-menu-2 text-xl"></i>
                </button>

                {{-- Welcome Section (Κρύβουμε το "Admin Dashboard" σε πολύ μικρά κινητά) --}}
                <div class="flex flex-col">
                    <h2 class="text-[14px] md:text-[15px] font-bold text-slate-900 leading-tight truncate max-w-[100px] md:max-w-none">
                        {{ explode(' ', $admin->name)[0] }}
                    </h2>
                    <p class="hidden sm:block text-[10px] md:text-[11px] font-semibold text-indigo-500/80 leading-tight">Admin Panel</p>
                </div>

                {{-- Badges: Εμφανίζονται ΜΟΝΟ από Tablet (md) και πάνω --}}
                <div class="hidden md:flex items-center gap-2">
                    {{-- IP Badge --}}
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50/40 rounded-xl border border-indigo-100/50">
                        <div class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[8px] font-bold text-indigo-400 uppercase leading-none">IP</span>
                            <span class="text-[11px] font-mono font-bold text-indigo-600 leading-tight mt-0.5">{{ $admin->last_login_ip ?? '0.0.0.0' }}</span>
                        </div>
                    </div>

                    {{-- Activity Badge --}}
                    <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="ti ti-clock-bolt text-slate-400 text-sm"></i>
                        <div class="flex flex-col">
                            <span class="text-[8px] font-bold text-slate-400 uppercase leading-none">Activity</span>
                            <span class="text-[11px] font-bold text-slate-600 leading-tight mt-0.5">
            {{-- Χρησιμοποιούμε diffForHumans με true για σύντομη μορφή (π.χ. 1m αντί για 1 minute) --}}
                                {{ $admin->last_login_at ? $admin->last_login_at->diffForHumans(null, true, true) : 'Now' }}
        </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="flex items-center gap-2 md:gap-4">

                {{-- Optimize Button (Σε mobile κρατάμε μόνο το εικονίδιο) --}}
                <button class="h-10 w-10 md:h-11 md:w-auto md:px-5 rounded-xl bg-slate-900 text-white hover:bg-indigo-600 transition-all flex items-center justify-center gap-2 shadow-lg shadow-slate-200 active:scale-95">
                    <i class="ti ti-refresh text-lg"></i>
                    <span class="text-[10px] font-black uppercase hidden md:block">Optimize</span>
                </button>

                {{-- Διαχωριστικό (Κρύβεται σε κινητά) --}}
                <div class="hidden sm:block w-px h-8 bg-slate-100 mx-1"></div>

                {{-- Profile --}}
                <div class="flex items-center gap-2">
                    {{-- Avatar (Λίγο μικρότερο σε mobile) --}}
                    <div class="relative">
                        <div class="h-9 w-9 md:h-11 md:w-11 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center font-black text-slate-700 shadow-sm">
                            <span class="text-xs md:text-sm">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                        </div>
                        <span class="absolute -top-0.5 -right-0.5 h-3 w-3 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>

                    {{-- Logout (Πάντα ορατό) --}}
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="h-9 w-9 md:h-11 md:w-11 flex items-center justify-center rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all">
                            <i class="ti ti-power text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>
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
