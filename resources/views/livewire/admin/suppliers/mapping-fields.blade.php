<div class="p-8 bg-[#f8fafc] min-h-screen">
    <div class="max-w-6xl mx-auto">

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2H3m2 0a2 2 0 012-2h1m2 13V7a2 2 0 012-2h6a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $supplier->name }}</h1>
                    <p class="text-slate-500 mt-2 font-medium italic">Data Source: {{ \Illuminate\Support\Str::limit($supplier->source_url, 50) }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button wire:click="analyzeXml" wire:loading.attr="disabled" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition-all flex items-center gap-2 group">
                    <svg wire:loading class="animate-spin h-5 w-5 text-indigo-600" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <svg wire:loading.remove class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Analyze XML
                </button>
                @if($step == 2)
                    <button wire:click="saveMapping" class="px-10 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95">
                        Save Changes
                    </button>
                @endif
            </div>
        </div>

        @if($step == 2)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($xmlFields as $field)
                    <div wire:key="field-{{ $field }}" class="bg-white p-6 rounded-[1.5rem] border {{ isset($mappings[$field]) && $mappings[$field] ? 'border-green-200 ring-4 ring-green-50' : 'border-slate-100' }} transition-all flex flex-col justify-between shadow-sm">

                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic">Source Node</span>
                                @if(isset($mappings[$field]) && $mappings[$field])
                                    <div class="flex items-center gap-1">
                                        <span class="text-[10px] font-bold text-green-600 uppercase">Linked</span>
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    </div>
                                @endif
                            </div>
                            <h3 class="font-mono text-sm font-bold text-slate-800 break-all mb-6">{{ $field }}</h3>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter ml-1">Connect to Database Field</label>
                            <div class="relative">
                                <select wire:model="mappings.{{ $field }}"
                                        class="appearance-none block w-full bg-slate-50 border-0 text-slate-700 py-3.5 px-4 pr-10 rounded-2xl leading-tight focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm font-semibold cursor-pointer">
                                    <option value="">-- Ignored --</option>
                                    @foreach($dbFields as $dbField)
                                        <option value="{{ $dbField }}">{{ $dbField }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>


                        <div class="mt-4 flex gap-4 border-t pt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="options.{{ $field }}.is_hashable" class="rounded text-indigo-600">
                                <span class="text-[10px] font-bold uppercase text-slate-500">Track Changes</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="options.{{ $field }}.is_unique" class="rounded text-red-600">
                                <span class="text-[10px] font-bold uppercase text-slate-500">Unique Check</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-12 py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100 flex flex-col items-center justify-center text-center px-10">
                <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mb-8">
                    <svg class="w-16 h-16 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">NO DATA ANALYZED</h2>
                <p class="text-slate-400 mt-4 max-w-sm font-medium">Πατήστε το κουμπί για να διαβάσουμε τη δομή του XML και να ξεκινήσει το mapping των πεδίων.</p>
                <button wire:click="analyzeXml" class="mt-10 px-12 py-5 bg-slate-900 text-white font-black rounded-2xl shadow-2xl shadow-slate-300 hover:bg-black transition-all hover:-translate-y-1">
                    START ANALYSIS
                </button>
            </div>
        @endif

    </div>
</div>
