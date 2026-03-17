{{-- ================= STATS ================= --}}
<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-5">

    @foreach($stats as $label => $value)
        <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400 font-medium">
                        {{ $label }}
                    </p>

                    <h3 class="mt-2 text-2xl font-semibold text-slate-900">
                        {{ $value }}
                    </h3>
                </div>
            </div>
        </div>

    @endforeach

</div>
