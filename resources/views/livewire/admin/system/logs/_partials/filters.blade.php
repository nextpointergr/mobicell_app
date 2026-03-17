
<div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition mb-5">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">


        <div class="md:col-span-3">
            <input type="text"
                   wire:model.live.debounce.500ms="search"
                   placeholder="{{ __('Search logs...') }}"
                   class="form-input w-full rounded-xl text-sm border-slate-300">
        </div>


        <div class="md:col-span-2">
            <select wire:model.live="adminId"
                    class="form-select w-full rounded-xl text-sm border-slate-300">
                <option value="">All admins</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Action --}}
        <div class="md:col-span-2">
            <select wire:model.live="action"
                    class="form-select w-full rounded-xl text-sm border-slate-300">
                <option value="">{{ __('All actions') }}</option>
                <option value="created">{{__('Created')}}</option>
                <option value="updated">{{ __('Updated') }}</option>
                <option value="deleted">{{ __('Deleted') }}</option>
            </select>
        </div>


        <div class="md:col-span-2">
            <select wire:model.live="subjectType"
                    class="form-select w-full rounded-xl text-sm border-slate-300">
                <option value="">{{ __('All models') }}</option>
                @foreach($models as $model)
                    <option value="{{ $model }}">
                        {{ class_basename($model) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date From --}}
        <div class="md:col-span-1">
            <input type="date"
                   wire:model.live="dateFrom"
                   class="form-input w-full rounded-xl text-sm border-slate-300">
        </div>


        <div class="md:col-span-1">
            <input type="date"
                   wire:model.live="dateTo"
                   class="form-input w-full rounded-xl text-sm border-slate-300">
        </div>


        <div class="md:col-span-1 flex items-center justify-end">
            <button
                wire:click="$set('adminId','');$set('action','');$set('search','');$set('subjectType','');$set('dateFrom','');$set('dateTo','');$set('ip','');"
                class="inline-flex items-center gap-2 px-5 h-10
                                       rounded-xl bg-red-600 text-white text-sm
                                       hover:bg-red-700 transition">
                <i class="material-symbols-rounded text-lg">delete</i>
                {{ __('Reset') }}
            </button>
        </div>

    </div>
</div>
