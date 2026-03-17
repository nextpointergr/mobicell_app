@props([
    'title',
    'subtitle' => null,
    'count' => null,
    'icon' => 'folder',
    'addLabel' => 'Add new',
    'addUrl' => null,
    'addCan' => null,
    'sync' => null,
])

<div class="flex flex-row items-center justify-between mb-8 gap-4">

    {{-- ARISTERA: TITLOS --}}
    <div class="flex items-center gap-4">
        <div class="hidden sm:flex h-12 w-12 rounded-2xl bg-slate-900 shadow-lg shadow-slate-200 items-center justify-center shrink-0">
            <i class="material-symbols-rounded text-white text-[24px]">
                {{ $icon }}
            </i>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-none">
                    {{ __($title) }}
                </h1>
                @if(!is_null($count))
                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-black border border-slate-200">
                        {{ number_format($count) }}
                    </span>
                @endif
            </div>
            @if($subtitle)
                <p class="text-slate-500 text-sm font-medium mt-1 hidden md:block">
                    {{ __($subtitle) }}
                </p>
            @endif
        </div>
    </div>

    {{-- DEKSIA: SYNC KAI ADD --}}
    <div class="flex items-center gap-3">

        @if($sync && ($sync['show'] ?? false))
            @php
                $lastSync = \DB::table('sync_runs')->where('status', 'completed')->latest('finished_at')->first();
            @endphp

            <div class="flex items-center gap-3 bg-white border border-slate-200 p-1.5 pr-4 rounded-2xl shadow-sm">
                {{-- Sync Button --}}
                <button
                    wire:click="$dispatch('sync-{{ $sync['entity'] }}')"
                    @disabled($sync['running'] ?? false)
                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all group active:scale-90 disabled:opacity-50"
                >
                    <i class="material-symbols-rounded text-[20px] {{ ($sync['running'] ?? false) ? 'animate-spin' : 'group-hover:rotate-180 transition-transform duration-700' }}">
                        sync
                    </i>
                </button>

                {{-- Last Sync Text --}}
                <div class="flex flex-col text-right leading-tight">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Τελευταίος Συγχρονισμός</span>
                    <span class="text-xs font-bold text-slate-700">
                        {{ $lastSync ? \Carbon\Carbon::parse($lastSync->finished_at)->diffForHumans() : 'Ποτέ' }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Add Button --}}
        @if($addUrl)
            @can($addCan)
                <a href="{{ $addUrl }}"
                   class="flex items-center justify-center h-12 w-12 sm:w-auto sm:px-5 rounded-2xl bg-slate-900 text-white shadow-lg shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95">
                    <i class="material-symbols-rounded text-[22px]">add</i>
                    <span class="hidden sm:inline-block ml-2 font-bold text-sm">{{ __($addLabel) }}</span>
                </a>
            @endcan
        @endif

    </div>
</div>
