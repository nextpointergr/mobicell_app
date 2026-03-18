<div class="space-y-12">
    {{-- ================= PAGE HEADER ================= --}}
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-indigo-50 flex items-center justify-center">
                <i class="material-symbols-rounded text-indigo-600 text-xl">
                    dashboard
                </i>
            </div>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">
                    {{ __('Dashboard') }}
                </h1>
                <p class="text-sm text-slate-500">
                    {{ __('Overview of your system activity') }}
                </p>
            </div>
        </div>

        {{-- Right side placeholder (future filters / date range) --}}
        <div class="text-xs text-slate-400">
            {{ now()->format('d M Y') }}
        </div>
    </div>

    <livewire:admin.settings.smtp.smtp-alert />

    <livewire:admin.global.erp-configuration-alert />

    @can('admin.dashboard.activity')
        @if($recentActivities && $recentActivities->count())
            <x-dashboard.activity-feed :activities="$recentActivities" />
        @endif
    @endcan




</div>
