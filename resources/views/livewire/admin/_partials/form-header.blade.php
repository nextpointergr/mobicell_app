@props([
    'id' => null,
    'title' => null,
    'editTitle' => 'Edit',
    'createTitle' => 'Create',
    'iconEdit' => 'edit',
    'iconCreate' => 'add',
    'badge' => null,
    'backUrl' => null,
])



<div class="flex items-start justify-between mb-10">

    {{-- LEFT --}}
    <div class="space-y-1">
        <div class="flex items-center gap-4">



            {{-- Title + Badge --}}
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold text-slate-900 leading-tight">
                    {{ $id ? __($editTitle) : __($createTitle) }}
                </h1>

                @if($id && $badge)
                    <span
                        class="
                            inline-flex items-center
                            px-3 py-1
                            rounded-full
                            text-xs font-medium
                            bg-emerald-50 text-emerald-700
                            border border-emerald-200
                        "
                    >
                        {{ $badge }}
                    </span>
                @endif
            </div>

        </div>
    </div>

    {{-- RIGHT --}}
    @if($backUrl)
        @include('livewire.admin._partials.back-to-list', [
            'url' => $backUrl
        ])
    @endif

</div>
