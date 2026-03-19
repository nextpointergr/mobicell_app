<div class="space-y-8 pb-32">
    <div class="max-w-7xl mx-auto py-10 px-4 space-y-10 {{ $isFullSync ? 'pointer-events-none' : '' }} transition-all duration-500">

        {{-- ACTION BAR --}}
        <div class="relative flex items-center justify-between bg-white/60 backdrop-blur-md p-3 rounded-3xl border border-slate-200/60 shadow-sm">
            <div class="flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-2xl">
                <button wire:click="selectAll" class="px-5 py-2 text-[11px] font-black uppercase tracking-widest text-slate-600 hover:text-indigo-600 hover:bg-white rounded-xl transition-all">
                    Select All
                </button>
                <button wire:click="deselectAll" class="px-5 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-red-500 hover:bg-white rounded-xl transition-all">
                    Clear
                </button>
            </div>

            <button wire:click="startFullShopSync" @if($isFullSync) disabled @endif class="group relative flex items-center gap-3 px-8 py-3 bg-slate-900 rounded-2xl hover:bg-black transition-all disabled:opacity-30">
                <span class="text-[11px] font-black uppercase tracking-widest text-white italic">Full XML Import</span>
            </button>
        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 transition-all duration-700">
            @foreach($entities as $id => $config)
                <div wire:key="sync-card-{{ $id }}-{{ $progress[$id] ?? 0 }}">
                <x-sync-card
                    :entity="$id"
                    :title="$config['title']"
                    :description="$config['desc']"
                    :run="$runs[$id] ?? null"
                    :total="$totals[$id] ?? 0"
                    :progress="$progress"
                    :completed="$completed"
                    :stats="$syncStats[$id] ?? null" {{-- Προσθήκη stats --}}
                    :selected="$selected"
                />
                </div>
            @endforeach
        </div>
    </div>

    {{-- STICKY FOOTER --}}
    @if(count($selected) > 0 || $isFullSync)
        <div class="fixed inset-x-0 bottom-0 z-50 flex justify-center px-4 pb-6">
            <div class="w-full max-w-2xl bg-slate-900/90 backdrop-blur-md rounded-3xl p-4 shadow-2xl border border-white/10 flex items-center justify-between">
                <div class="text-white text-sm font-bold ml-4">
                    {{ count($selected) }} Suppliers selected
                </div>
                <button wire:click="startSelected" class="bg-indigo-500 hover:bg-indigo-400 text-white px-8 py-3 rounded-2xl font-bold text-sm transition-all flex items-center gap-3">
                    @if(count($progress) > 0)
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Syncing...
                    @else
                        Start Sync
                    @endif
                </button>
            </div>
        </div>
    @endif
</div>
