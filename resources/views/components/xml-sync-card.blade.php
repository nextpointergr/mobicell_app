@props(['title', 'run', 'total', 'entity', 'progress' => [], 'completed' => [], 'selected' => []])

@php
    $isSelected = in_array($entity, $selected ?? []);
    $isCompleted = $completed[$entity] ?? false;
    $running = array_key_exists($entity, $progress) && !$isCompleted;
    $processed = $progress[$entity] ?? ($run->processed ?? 0);
    // Στο XML δεν ξέρουμε το σύνολο από πριν, οπότε το 100% είναι ενδεικτικό αν τελειώσει
    $percent = $isCompleted ? 100 : 0;
    $lastRunAt = $run?->finished_at ?? $run?->created_at;
@endphp

<div id="card-{{ $entity }}" wire:click="toggleEntity({{ $entity }})"
     class="group relative flex flex-col rounded-2xl border transition-all duration-300 cursor-pointer h-full
    {{ $isSelected ? 'border-indigo-500 bg-indigo-50/20 ring-1 ring-indigo-500 shadow-lg' : 'border-slate-200 bg-white hover:border-slate-400 shadow-sm' }}">

    <div class="p-5 flex flex-col h-full">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl transition-all
                {{ $isSelected ? 'bg-indigo-600 text-white' : 'bg-slate-50 text-slate-400 group-hover:bg-slate-100' }}
                {{ $running ? 'animate-pulse' : '' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
            </div>

            <div class="flex-1 min-w-0">
                <h3 class="truncate text-sm font-black text-slate-900 uppercase tracking-tight">{{ $title }}</h3>
                <div class="flex items-baseline gap-1">
                    <span class="text-xl font-black text-slate-900">{{ number_format($total) }}</span>
                    <span class="text-[9px] font-bold uppercase text-slate-400">Products</span>
                </div>
            </div>

            <div class="h-5 w-5 rounded-full border flex items-center justify-center {{ $isSelected ? 'bg-indigo-600 border-indigo-600' : 'bg-white border-slate-300' }}">
                @if($isSelected)<div class="h-2 w-2 rounded-full bg-white"></div>@endif
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100">
            @if($running)
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-[10px] font-black uppercase text-indigo-600 italic">
                        <span class="flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-ping"></span>
                            Syncing...
                        </span>
                        <span>{{ number_format($processed) }} items</span>
                    </div>
                    <div class="h-1.5 w-full bg-indigo-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-600 animate-pulse" style="width: 100%"></div>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        {{ $lastRunAt ? $lastRunAt->diffForHumans() : 'Never Synced' }}
                    </span>
                    @if($isCompleted)
                        <span class="text-[9px] font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg uppercase">Success</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
