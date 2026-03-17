@props(['activities'])

<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center">
            <i class="material-symbols-rounded text-slate-600 text-lg">
                history
            </i>
        </div>

        <div>
            <h2 class="text-base font-semibold text-slate-900">
                {{ __('Recent activity') }}
            </h2>
            <p class="text-xs text-slate-500">
                {{ __('Latest system changes') }}
            </p>
        </div>
    </div>

    {{-- TIMELINE --}}
    <div class="space-y-6">

        @forelse($activities as $activity)

            <div class="flex gap-4 group">

                {{-- DOT --}}
                <div class="relative">
                    <div class="w-3 h-3 bg-indigo-500 rounded-full mt-2"></div>
                </div>

                {{-- CONTENT --}}
                <div class="flex-1">

                    <div class="text-sm text-slate-700 leading-relaxed">

                        <span class="font-medium text-slate-900">
                            {{ $activity->causer?->name ?? 'System' }}
                        </span>

                        @if($activity->description === 'created')
                            {{ __('created') }}
                        @elseif($activity->description === 'updated')
                            {{ __('updated') }}
                        @elseif($activity->description === 'deleted')
                            {{ __('deleted') }}
                        @else
                            {{ $activity->description }}
                        @endif

                        <span class="font-medium">
                            {{ class_basename($activity->subject_type) }}
                        </span>

                    </div>

                    <div class="text-xs text-slate-400 mt-1">
                        {{ $activity->created_at->diffForHumans() }}
                    </div>

                </div>
            </div>
        @empty
            <div class="text-sm text-slate-400">
                {{ __('No recent activity') }}
            </div>
        @endforelse
    </div>
</div>
