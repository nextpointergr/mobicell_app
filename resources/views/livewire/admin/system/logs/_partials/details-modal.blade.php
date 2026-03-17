
@if($selectedLog)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">

        <div class="bg-white w-full max-w-3xl rounded-2xl p-6 shadow-xl">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">{{ __('Log Details') }}</h3>
                <button wire:click="closeModal"
                        class="text-slate-400 hover:text-slate-700">
                    ✕
                </button>
            </div>

            <div class="space-y-3 text-sm">

                <div><strong>{{ __('Action:') }}</strong> {{ ucfirst($selectedLog->description) }}</div>
                <div><strong>{{ __('Admin:') }}</strong> {{ $selectedLog->causer?->name ?? 'System' }}</div>
                <div><strong>{{__('Model:')}}</strong> {{ class_basename($selectedLog->subject_type) }}</div>
                <div><strong>{{ __('ID:') }}</strong> {{ $selectedLog->subject_id }}</div>
                <div><strong>{{ __('Date:') }}</strong> {{ $selectedLog->created_at }}</div>

                @if($selectedLog->properties)
                    <div>
                        <strong>Properties:</strong>
                        <pre class="bg-slate-100 p-4 rounded-xl text-xs overflow-auto mt-2">
{{ json_encode($selectedLog->properties, JSON_PRETTY_PRINT) }}
                            </pre>
                    </div>
                @endif

            </div>

        </div>

    </div>
@endif
