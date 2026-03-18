





<div class="space-y-8 pb-32"> {{-- Προσθήκη padding bottom για να μην κρύβεται το περιεχόμενο από το sticky --}}

    <div class="max-w-7xl mx-auto py-10 px-4 space-y-10 {{ $isFullSync ? 'pointer-events-none' : '' }} transition-all duration-500">

        {{-- MODERN ACTION BAR --}}
        <div class="relative flex items-center justify-between bg-white/60 backdrop-blur-md p-3 rounded-3xl border border-slate-200/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">

            {{-- Left Side: Selection Controls --}}
            <div class="flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-2xl">
                <button wire:click="selectAll" class="px-5 py-2 text-[11px] font-black uppercase tracking-widest text-slate-600 hover:text-indigo-600 hover:bg-white rounded-xl transition-all duration-200">
                    {{ __('Select All') }}
                </button>
                <button wire:click="deselectAll" class="px-5 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-red-500 hover:bg-white rounded-xl transition-all duration-200">
                    {{ __('Clear') }}
                </button>
            </div>

            {{-- Center: Active Status (Hidden when idle) --}}
            @if(count($selected) > 0)
                <div class="absolute left-1/2 -translate-x-1/2 hidden md:flex items-center gap-2 animate-in fade-in zoom-in duration-300">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-tighter text-slate-400">
                {{ count($selected) }} entities ready to sync
            </span>
                </div>
            @endif

            {{-- Right Side: Master Button --}}
            <button
                wire:click="startFullShopSync"
                @if($isFullSync) disabled @endif
                class="group relative flex items-center gap-3 px-8 py-3 bg-slate-900 rounded-2xl transition-all duration-300 hover:bg-black hover:shadow-[0_10px_20px_rgba(0,0,0,0.1)] disabled:opacity-30"
            >
                <div class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </div>
                <span class="text-[11px] font-black uppercase tracking-[0.15em] text-white">
                {{ __('Full Shop Sync') }}
            </span>
                <svg class="w-4 h-4 text-slate-400 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>

        {{-- GRID WITH CARDS --}}
        <div class="relative">
            {{-- Decorative background gradient (προαιρετικό για βάθος) --}}
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-50 rounded-full blur-[120px] -z-10 opacity-60"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 {{ $isFullSync ? 'opacity-40 grayscale-[0.5]' : '' }} transition-all duration-700"
                 x-data="{
        lastScrolledEntity: '',
        handleAutoScroll(progress) {
            // Παίρνουμε το κλειδί της τελευταίας οντότητας που συγχρονίζεται
            const activeEntities = Object.keys(progress);
            if (activeEntities.length === 0) return;

            const currentEntity = activeEntities[activeEntities.length - 1];


            if (currentEntity !== this.lastScrolledEntity) {
            this.lastScrolledEntity = currentEntity;
            const el = document.getElementById('card-' + currentEntity);
            if (el) {
            el.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
            });
            }
            }
            }
            }"
            {{-- Κάθε φορά που αλλάζει το progress στο Livewire, τρέχει η συνάρτηση --}}
            x-init="$watch('$wire.progress', value => handleAutoScroll(value))"
            >     @foreach($entities as $id => $config)
                    <div class="h-full transform transition-all duration-500 hover:z-10">
                        <x-sync-card
                            :entity="$id"
                            :title="__($config['title'])"
                            :description="__($config['desc'])"
                            :run="$runs[$id] ?? null"
                            :total="$totals[$id] ?? 0"
                            :progress="$progress"
                            :completed="$completed"
                            :stats="$syncStats[$id] ?? null"
                            :selected="$selected"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(count($selected) > 0 || $isFullSync)
        <div class="fixed inset-x-0 bottom-0 z-50 flex justify-center px-3 sm:px-4 pb-[calc(env(safe-area-inset-bottom)+12px)]">

            <div class="w-full max-w-2xl animate-in fade-in slide-in-from-bottom-8 duration-500">

                <div class="bg-slate-900/90 backdrop-blur-md rounded-2xl sm:rounded-3xl p-4 shadow-2xl border border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

                    {{-- LEFT --}}
                    <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto">

                        <div class="flex -space-x-2">
                            @foreach($selected as $sel)
                                <div class="h-8 w-8 rounded-full bg-indigo-500 border-2 border-slate-900 flex items-center justify-center text-[10px] text-white font-bold uppercase">
                                    {{ substr($sel, 0, 1) }}
                                </div>
                            @endforeach
                        </div>

                        <div class="leading-tight">
                            <div class="text-white text-sm font-bold">
                                {{ count($selected) }} {{ __('Entities selected') }}
                            </div>
                            <div class="text-slate-400 text-xs">
                                {{ $isFullSync ? __('System is locked during full sync') : __('Ready to push updates') }}
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto justify-end">

                        <button
                            wire:click="deselectAll"
                            class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-slate-300 hover:text-white transition"
                        >
                            {{ __('Cancel') }}
                        </button>

                        <button
                            wire:click="startSelected"
                            class="bg-indigo-500 hover:bg-indigo-400 text-white px-5 sm:px-8 py-3 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2 transition-all active:scale-95 w-full sm:w-auto"
                        >
                            @if($isFullSync || count($progress) > 0)
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('Syncing...') }}
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                {{ __('Start Sync Now') }}
                            @endif
                        </button>

                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- CELEBRATION OVERLAY ΜΕ CARTOON DANCING GIF --}}
    <div
        x-data="{ show: false }"
        @sync-finished.window="show = true; setTimeout(() => show = false, 8000)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white/95 backdrop-blur-2xl"
    >
        {{-- Το GIF --}}
        <div class="relative w-80 h-80">
            {{-- Floating shapes για εφέ --}}
            <div class="absolute inset-0 bg-indigo-500/10 blur-3xl rounded-full animate-pulse"></div>

            <img src="{{ asset('images/happy.gif') }}" alt="Logo"       class="relative z-10 w-full h-full object-contain">
        </div>

        <div class="text-center mt-6">
            <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">
                {{ __('Sync Complete!') }}
            </h2>
            <p class="mt-2 text-slate-500 font-bold tracking-widest text-[10px] uppercase">
                {{ __('Everything is up to date') }}
            </p>

            <button
                @click="show = false"
                class="mt-10 px-8 py-3 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all active:scale-95"
            >
                {{ __('Great, thanks!') }}
            </button>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>
