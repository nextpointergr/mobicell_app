<div
    class="relative"
    x-data="systemPerformanceTools()"
    x-on:run-commands.window="confirmAndRun($event.detail.keys)"
>
    {{-- TOP BAR --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">{{ __('System Performance') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Cache, optimize and system maintenance tools.') }}</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500 hidden sm:inline">
                {{ count($selected) }} {{ __('selected') }}
            </span>

            <button
                type="button"
                wire:click="selectAll"
                class="px-3 py-2 text-sm rounded-lg border bg-white hover:bg-gray-50 transition"
            >
                {{ __('Select all') }}
            </button>

            <button
                type="button"
                wire:click="deselectAll"
                class="px-3 py-2 text-sm rounded-lg border bg-white hover:bg-gray-50 transition"
            >
                {{ __('Deselect all') }}
            </button>
        </div>
    </div>

    @php
        $groups = [
            'Cache & Optimize' => [
                'cache_clear'    => 'Clear Cache',
                'config_clear'   => 'Clear Config',
                'route_clear'    => 'Clear Routes',
                'event_clear'    => 'Clear Events',
                'optimize_clear' => 'Optimize Clear (All)',
            ],
            'Cache Build' => [
                'config_cache' => 'Cache Config',
                'route_cache'  => 'Cache Routes',
                'view_cache'   => 'Cache Views',
                'event_cache'  => 'Cache Events',
            ],
            'System' => [
                'queue_restart' => 'Restart Queues',
                'schedule_run'  => 'Run Scheduler',
                'storage_link'  => 'Create Storage Link',
            ],
        ];
    @endphp

    {{-- CARDS --}}
    <div class="grid lg:grid-cols-3 gap-6">
        @foreach($groups as $title => $tools)
            <div class="rounded-2xl border bg-white shadow-sm">
                <div class="px-5 pt-5 pb-3">
                    <h3 class="text-sm font-semibold text-gray-900">{{ __($title) }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Choose actions to run') }}</p>
                </div>

                <div class="px-5 pb-5 space-y-4">
                    @foreach ($tools as $key => $label)
                        <div wire:key="tool-{{ $key }}" class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-800">{{ __($label) }}</span>

                                @if(in_array($key, ['optimize_clear','route_cache']))
                                    <span class="text-xs text-amber-600 mt-0.5">
                                        {{ __('May affect performance temporarily') }}
                                    </span>
                                @endif
                            </div>

                            <label class="cursor-pointer select-none">
                                <input
                                    type="checkbox"
                                    wire:model.defer="selected"
                                    value="{{ $key }}"
                                    class="sr-only peer"
                                >
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-indigo-600 transition">
                                    <span class="absolute top-[2px] left-[2px] w-5 h-5 bg-white rounded-full transition-all peer-checked:translate-x-5"></span>
                                </div>
                            </label>
                        </div>

                        @if(!$loop->last)
                            <div class="h-px bg-gray-100"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- CENTERED ACTION --}}
    <div class="mt-8 flex justify-center">
        <button
            wire:click="runSelected"
            wire:loading.attr="disabled"
            wire:target="runSelected"
            @disabled(count($selected) === 0)
            class="
                inline-flex items-center justify-center gap-2
                bg-indigo-600 text-white
                px-8 py-3 rounded-xl
                shadow-sm
                hover:bg-indigo-700
                transition
                disabled:opacity-50
                disabled:cursor-not-allowed
            "
        >
            <span wire:loading.remove wire:target="runSelected" class="flex items-center gap-2">
                <i class="material-symbols-rounded text-lg">play_arrow</i>
                {{ __('Run Selected') }}
                @if(count($selected))
                    <span class="text-white/80 text-sm">({{ count($selected) }})</span>
                @endif
            </span>

            <span wire:loading wire:target="runSelected" class="flex items-center gap-2">
                <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                {{ __('Running...') }}
            </span>
        </button>
    </div>
</div>

{{-- JS --}}
<script>
    function systemPerformanceTools() {
        return {
            async confirmAndRun(keys) {
                const r = await Swal.fire({
                    icon: 'warning',
                    title: 'Run commands',
                    text: 'These actions will run on the server now.',
                    confirmButtonText: 'Run',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel'
                });

                if (!r.isConfirmed) return;

                Swal.fire({
                    title: 'Running...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                try {
                    const res = await fetch(@json(route('admin.system.run-commands')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        },
                        body: JSON.stringify({ keys: keys })
                    });

                    const text = await res.text();

                    let data;
                    try { data = JSON.parse(text); }
                    catch (e) {
                        console.error('Non-JSON response:', text);
                        await Swal.fire({ icon: 'error', title: 'Server error', text: 'Invalid response. Check logs.' });
                        return;
                    }

                    if (!data.ok) {
                        await Swal.fire({ icon: 'error', title: 'Failed', text: data.message || 'Error' });
                        return;
                    }

                    let html = '';
                    (data.results || []).forEach(function (x) {
                        html += '<div style="text-align:left;font-family:monospace;">' + String(x)
                                .replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;')
                                .replaceAll('"','&quot;').replaceAll("'","&#039;")
                            + '</div>';
                    });

                    await Swal.fire({
                        icon: 'success',
                        title: 'Completed',
                        html: html,
                        confirmButtonText: 'OK'
                    });

                } catch (e) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: (e && e.message) ? e.message : 'Unexpected error'
                    });
                }
            }
        }
    }
</script>
