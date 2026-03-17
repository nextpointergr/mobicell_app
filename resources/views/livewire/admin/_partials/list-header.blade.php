@props([
    'title',
    'subtitle' => null,
    'count' => null,
    'icon' => 'folder',
    'addLabel' => 'Add new',
    'addUrl' => null,
    'addCan' => null,

    'sync' => null, // array
])

<div class="flex items-start justify-between mb-8">

    {{-- LEFT --}}
    <div class="flex items-start gap-3">

        {{-- Icon --}}
        <div class="h-12 w-12 rounded-lg bg-white shadow-sm flex items-center justify-center mt-0.5">
            <i class="material-symbols-rounded text-[18px] text-slate-700">
                {{ $icon }}
            </i>
        </div>

        {{-- Title --}}
        <div class="space-y-0.5">

            <div class="flex items-center gap-2">
                <h1 class="text-xl font-semibold text-slate-900 leading-tight">
                    {{ __($title) }}
                </h1>

                @if(!is_null($count))
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-600 text-white">
                        {{ $count }}
                    </span>
                @endif
            </div>

            @if($subtitle)
                <p class="text-sm text-slate-500 leading-snug max-w-xl">
                    {{ __($subtitle) }}
                </p>
            @endif

        </div>
    </div>


    {{-- ACTIONS --}}
    <div class="flex items-center gap-2">

        @if($sync && ($sync['show'] ?? false))

            <button
                wire:click="$dispatch('sync-{{ $sync['entity'] }}')"
                @disabled($sync['running'] ?? false)
                title="Sync {{ $sync['entity'] }}"
                class="group relative inline-flex items-center justify-center
           h-11 w-11 rounded-full
           bg-gradient-to-br from-indigo-500 to-indigo-600
           hover:from-indigo-600 hover:to-indigo-700
           text-white
           shadow-md hover:shadow-lg
           transition-all duration-300
           active:scale-95
           disabled:opacity-50 disabled:cursor-not-allowed"
            >

                @if($sync['running'] ?? false)

                    <i class="material-symbols-rounded text-[20px] animate-spin">
                        sync
                    </i>

                @else

                    <i class="material-symbols-rounded text-[20px]
transition-transform duration-500
group-hover:rotate-180">
                        sync
                    </i>

                @endif

            </button>

        @endif


        {{-- Add --}}
        @if($addUrl)
            @can($addCan)

                <a
                    href="{{ $addUrl }}"
                    title="{{ __($addLabel) }}"
                    class="group inline-flex items-center justify-center
                           h-11 w-11
                           rounded-full
                           bg-slate-900 text-white
                           shadow
                           transition-all duration-200
                           hover:bg-black hover:scale-105
                           active:scale-95
                           focus:outline-none focus:ring-2 focus:ring-slate-300"
                >
                    <i class="material-symbols-rounded text-[22px] leading-none">
                        add
                    </i>
                </a>

            @endcan
        @endif

    </div>

</div>
