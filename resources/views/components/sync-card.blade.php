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
    $percent = $total
        ? min(100, round(($processed / $total) * 100))
        : 0;
    $firstSync = !$total;
    $lastRunAt = $run?->finished_at ?? $run?->created_at;
@endphp



<div
    wire:click="toggleEntity('{{ $entity }}')"
    class="group relative overflow-hidden rounded-3xl border bg-white p-6 transition-all duration-300 cursor-pointer
    {{ $isSelected ? 'border-indigo-300 ring-4 ring-indigo-100 shadow-lg shadow-indigo-100/50' : 'border-slate-200 shadow-sm hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg' }}
    {{ $running ? 'border-indigo-300 ring-4 ring-indigo-100' : '' }}
    {{ $isCompleted ? 'border-emerald-200 ring-4 ring-emerald-100' : '' }}"
>
    <div class="absolute inset-x-0 top-0 h-1
        {{ $isCompleted ? 'bg-gradient-to-r from-emerald-500 to-green-400' : ($running ? 'bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500' : 'bg-slate-100') }}">
    </div>

    {{-- selection checkbox --}}
    <div class="absolute right-5 top-5">
        <div class="flex h-6 w-6 items-center justify-center rounded-full border transition
            {{ $isSelected ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-slate-300 bg-white text-transparent' }}">
            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.2 7.2a1 1 0 01-1.415 0l-3-3a1 1 0 011.414-1.42l2.293 2.294 6.493-6.494a1 1 0 011.415 0z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>

    {{-- header --}}
    <div class="flex items-start gap-4">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl
            {{ $running ? 'bg-indigo-50 text-indigo-600' : ($isCompleted ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-700') }}">
            @switch($entity)
                @case('customers')
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                        <circle cx="9.5" cy="7" r="4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-3-3.87"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                    @break

                @case('taxes')
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 1v22"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 5H9.5a3.5 3.5 0 000 7H14.5a3.5 3.5 0 010 7H6"/>
                    </svg>
                    @break

                @case('countries')
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a15 15 0 010 18"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a15 15 0 000 18"/>
                    </svg>
                    @break

                @case('payments')
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 10h20"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 15h2"/>
                    </svg>
                    @break

                @case('categories')
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h7V4H4v3zm9 13h7v-7h-7v7zM4 20h7v-9H4v9zm9-9h7V4h-7v7z"/>
                    </svg>
                    @break

                @case('carriers')
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11v8H3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h3l3 3v2h-6z"/>
                        <circle cx="7.5" cy="18.5" r="1.5"/>
                        <circle cx="17.5" cy="18.5" r="1.5"/>
                    </svg>
                @break

                @default
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="4" width="16" height="16" rx="3"/>
                    </svg>
            @endswitch
        </div>

        <div class="pr-10">
            <h3 class="text-lg font-semibold tracking-tight text-slate-900">
                {{ $title }}
            </h3>

            @if($description)
                <p class="mt-1 text-sm text-slate-500">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>

    {{-- meta --}}
    <div class="mt-6 flex items-center justify-between">
        <div>
            <div class="text-3xl font-bold tracking-tight text-slate-900">
                {{ number_format($total) }}
            </div>
            <div class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500">
                {{ __('records') }}
            </div>
        </div>

        @if($isCompleted && !$running)
            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.2 7.2a1 1 0 01-1.415 0l-3-3a1 1 0 011.414-1.42l2.293 2.294 6.493-6.494a1 1 0 011.415 0z" clip-rule="evenodd"/>
                </svg>
                {{ __('Synced') }}
            </div>
        @elseif($running)
            <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" d="M22 12A10 10 0 0012 2" stroke="currentColor" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                {{ __('Syncing') }}
            </div>
        @elseif($isSelected)
            <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                {{ __('Selected') }}
            </div>
        @endif
    </div>

    {{-- progress --}}
    @if($running && !$isCompleted)
        <div class="mt-6 space-y-3">
            <div class="flex items-center justify-between text-xs font-medium text-slate-500">
                <span>{{ $firstSync ? __('Discovering records...') : __('Synchronization progress') }}</span>
                @if(!$firstSync)
                    <span>{{ $percent }}%</span>
                @endif
            </div>

            @if($firstSync)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    {{ number_format($processed) }} ΄{{ __('records discovered') }}
                </div>
            @else
                <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                    <div
                        class="h-full rounded-full bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 transition-all duration-500"
                        style="width: {{ $percent }}%"
                    ></div>
                </div>

                <div class="text-xs text-slate-400">
                    {{ number_format($processed) }} / {{ number_format($total) }}
                </div>
            @endif
        </div>
    @endif

    {{-- footer --}}
    <div class="mt-6 border-t border-slate-100 pt-4 space-y-3">
        <div class="flex items-center justify-between text-xs">
            <span class="font-medium uppercase tracking-wide text-slate-400">
                {{ __('Last run') }}
            </span>
            <span class="font-medium text-slate-700">
                {{ $lastRunAt ? $lastRunAt->diffForHumans() : __('Never') }}
            </span>
        </div>

        @if($stats)
            <div class="flex flex-wrap gap-2">
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    {{ number_format($stats['created'] ?? 0) }} {{ __('new') }}
                </div>

                <div class="inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                    {{ number_format($stats['updated'] ?? 0) }} {{ __('updated') }}
                </div>
            </div>
        @endif
    </div>
</div>
