<div>
    @if($erpConfig['hasIssues'])
        <div class="relative overflow-hidden rounded-2xl border border-rose-100 bg-white p-4 shadow-lg shadow-rose-50/50 group">

            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-rose-50 opacity-50 transition-transform group-hover:scale-150 duration-700"></div>

            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">

                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 ring-4 ring-rose-50/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>

                    <div class="flex flex-col space-y-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-semibold text-slate-800">
                                {{ __('Εκκρεμότητα Ρύθμισης ERP') }}
                            </h3>
                            <span class="inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-700 uppercase tracking-wider">
                                {{ $erpConfig['invalidCount'] }} Stores
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 leading-relaxed max-w-lg">
                            {{ __('Εντοπίστηκαν ελλιπή στοιχεία σύνδεσης στα παρακάτω καταστήματα:') }}
                            <span class="font-medium text-slate-700 italic">
                                {{ collect($erpConfig['invalidStores'])->pluck('name')->join(', ') }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center">
                    <a href="{{ route('admin.stores') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white shadow-md transition-all hover:bg-slate-800 hover:shadow-lg active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-1.5 h-4 w-4 opacity-70">
                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                        {{ __('Διόρθωση Τώρα') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
