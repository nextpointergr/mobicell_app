<div>
    @if($shouldShow)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 flex items-start justify-between gap-4">

            <div class="flex items-start gap-3">

                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="material-symbols-rounded text-amber-600 text-lg">
                        warning
                    </i>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-amber-800">
                        {{ __('SMTP is not validated') }}
                    </h3>

                    <p class="text-xs text-amber-700 mt-1">
                        {{ __('Please send a test email to activate the SMTP configuration.') }}
                    </p>
                </div>

            </div>

            <a href="{{ route('admin.settings.smtp') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-4 py-2 text-xs font-medium text-white hover:bg-amber-700 transition">
                <i class="material-symbols-rounded text-sm">
                    settings
                </i>
                {{ __('Configure SMTP') }}
            </a>

        </div>
    @endif
</div>
