<div class="my-8 px-6">
    @if($erpConfig['hasIssues'])
        <div class="relative group mx-auto max-w-5xl">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-100 to-orange-100 rounded-[2rem] blur opacity-30"></div>

            <div class="relative flex flex-col lg:flex-row items-center justify-between gap-6 bg-white border border-slate-100 p-6 rounded-[1.5rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)]">

                <div class="flex items-center gap-6">
                    <div class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600 transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 rounded-2xl bg-red-100/50 animate-ping opacity-20"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="relative w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM2.25 12c0 5.385 4.365 9.75 9.75 9.75s9.75-4.365 9.75-9.75-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12Z" />
                        </svg>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-[10px] font-bold text-red-700 uppercase tracking-wider">
                                ERP Attention Required
                            </span>
                            <span class="text-[11px] font-medium text-slate-400">Ref: SYNC_ERR_{{ now()->format('Hi') }}</span>
                        </div>

                        <h3 class="text-lg font-semibold text-slate-800 tracking-tight">
                            Υπάρχουν <span class="text-red-600 font-bold">{{ $erpConfig['invalidCount'] }} καταστήματα</span> χωρίς σύνδεση
                        </h3>

                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate max-w-md italic">
                                {{ collect($erpConfig['invalidStores'])->pluck('name')->join(', ') }}
                            </span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.stores') }}"
                   class="group/btn relative flex items-center gap-3 overflow-hidden rounded-full bg-slate-900 px-7 py-3.5 text-white transition-all hover:bg-black hover:shadow-2xl active:scale-95">
                    <span class="text-sm font-bold tracking-tight">{{ __('Ρύθμιση Καταστημάτων') }}</span>
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-white/10 group-hover/btn:bg-white/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </a>

            </div>
        </div>
    @endif
</div>
