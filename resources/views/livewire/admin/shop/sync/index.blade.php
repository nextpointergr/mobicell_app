





















<div class="space-y-8">

    {{-- FULL WIDTH HEADER --}}
    <div class="w-full border-b border-slate-200 bg-white">
        <div class="max-w-6xl mx-auto py-10">
            <div class="flex items-start justify-between gap-8">

                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                        {{ __('ERP Integration') }}
                    </div>

                    <h1 class="mt-4 text-3xl font-bold text-slate-900">
                        {{ __('ERP Synchronization') }}
                    </h1>

                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Επιλέξτε ποιες οντότητες θέλετε να συγχρονίσετε από το ERP
                        και παρακολουθήστε την πρόοδο του τελευταίου run.
                    </p>
                </div>

                <div class="flex gap-4">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-6 py-4">
                        <div class="text-xs text-slate-500 uppercase">
                            {{ __('Entities') }}
                        </div>

                        <div class="text-2xl font-bold text-slate-900 mt-1">
                            6
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-6 py-4">
                        <div class="text-xs text-slate-500 uppercase">
                            {{ __('Selected') }}
                        </div>

                        <div class="text-2xl font-bold text-slate-900 mt-1">
                            {{ count($selected) }}
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-6 py-4">
                        <div class="text-xs text-slate-500 uppercase">
                            {{ __('Status') }}
                        </div>

                        <div class="text-sm font-semibold mt-2 {{ count($progress) ? 'text-indigo-600' : 'text-green-600' }}">
                            {{ count($progress) ? __('Sync running') : __('Ready to sync') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-6xl mx-auto py-10 space-y-8">

        {{-- ACTION BAR --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button
                        wire:click="selectAll"
                        class="flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                        {{ __('Select all') }}
                    </button>

                    <button
                        wire:click="deselectAll"
                        class="flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 6l-12 12"/>
                        </svg>
                        {{__('Clear')}}
                    </button>
                </div>

                <button
                    wire:click="startSelected"
                    @disabled(empty($selected) || count($progress))
                    class="flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition disabled:opacity-40"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    {{ __('Start synchronization') }}
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($entities as $id => $config)
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

            @endforeach

        </div>
    </div>
</div>
