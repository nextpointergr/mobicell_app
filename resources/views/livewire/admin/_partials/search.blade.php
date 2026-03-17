<div class="relative w-64 shrink-0">
    <input
        type="text"
        wire:model.live="search"
        placeholder="{{ __('Search...') }}"
        class="form-input h-10 w-full rounded-xl
               border-slate-300 bg-white
               ps-11 text-sm
               focus:border-indigo-500 focus:ring-indigo-500"
    >

    <div class="absolute inset-y-0 start-4 flex items-center pointer-events-none">
        <i class="ti ti-search text-lg text-slate-400"></i>
    </div>
</div>
