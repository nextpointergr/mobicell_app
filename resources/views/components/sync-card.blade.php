@props([
    'title',
    'description' => null,
    'status' => false,
    'run' => null,
    'total' => 0,
    'entity',
    'progress' => [],
    'completed' => [],
    'selected' => [],
    'stats' => null,
])

@php
    $isSelected = in_array($entity, $selected ?? []);
    $isCompleted = $completed[$entity] ?? false;
    $running = array_key_exists($entity, $progress) && !$isCompleted;
    $processed = $progress[$entity] ?? ($run->processed ?? 0);
    $percent = $total ? min(100, round(($processed / $total) * 100)) : 0;
    $lastRunAt = $run?->finished_at ?? $run?->created_at;
@endphp

<div
    id="card-{{ $entity }}"
    wire:click="toggleEntity('{{ $entity }}')"
    class="group relative flex flex-col overflow-hidden rounded-2xl border transition-all duration-300 cursor-pointer h-full
    {{ $isSelected
        ? 'border-indigo-500 bg-indigo-50/20 shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-indigo-500'
        : 'border-slate-200 bg-white hover:border-slate-400 shadow-sm' }}"
>
    {{-- Glow effect only on selection --}}
    @if($isSelected)
        <div class="absolute -right-4 -top-4 h-16 w-16 rounded-full bg-indigo-500/10 blur-2xl"></div>
    @endif

    <div class="p-4 flex flex-col h-full">
        {{-- Header Section --}}
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition-all duration-300
                {{ $isSelected ? 'bg-indigo-600 text-white shadow-indigo-200 shadow-lg' : 'bg-slate-50 text-slate-500 group-hover:bg-slate-100' }}
                {{ $running ? 'animate-pulse' : '' }}">

                @switch($entity)
                    @case('categories')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16m-7 6h7"/></svg>
                        @break
                    @case('products')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @break
                    @default
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                @endswitch
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="truncate text-[13px] font-bold text-slate-900 tracking-tight">
                    {{ $title }}
                </h3>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-lg font-black text-slate-900 tracking-tighter">{{ number_format($total) }}</span>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Items</span>
                </div>
            </div>

            {{-- Minimal Selection Dot --}}
            <div class="h-4 w-4 shrink-0 rounded-full border transition-all duration-300 flex items-center justify-center
                {{ $isSelected ? 'bg-indigo-600 border-indigo-600' : 'bg-white border-slate-300' }}">
                @if($isSelected)
                    <div class="h-1.5 w-1.5 rounded-full bg-white"></div>
                @endif
            </div>
        </div>

        {{-- Progress or Last Run Footer --}}
        <div class="mt-4 pt-3 border-t border-slate-50/50">
            @if($running)
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-[10px] font-bold uppercase text-indigo-600">
                        <span class="flex items-center gap-1.5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                            </span>
                            Syncing
                        </span>
                        <span>{{ $percent }}%</span>
                    </div>
                    <div class="h-1 w-full overflow-hidden rounded-full bg-indigo-100">
                        <div class="h-full bg-indigo-600 transition-all duration-500" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                        {{ $lastRunAt ? $lastRunAt->diffForHumans() : 'Never' }}
                    </span>

                    <div class="flex gap-1">
                        @if($stats && ($stats['created'] > 0 || $stats['updated'] > 0))
                            <div class="flex gap-1">
                                @if($stats['created'] > 0)
                                    <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">+{{ $stats['created'] }}</span>
                                @endif
                                @if($stats['updated'] > 0)
                                    <span class="text-[9px] font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded-md">~{{ $stats['updated'] }}</span>
                                @endif
                            </div>
                        @elseif($isCompleted)
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-500">Ready</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
