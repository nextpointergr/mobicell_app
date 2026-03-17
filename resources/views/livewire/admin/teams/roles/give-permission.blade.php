<div class="relative">
    {{-- HEADER --}}
    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i class="material-symbols-rounded text-indigo-600">shield</i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                        {{ $role->name }}
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                            {{ __('Permissions') }}
                        </span>
                    </h4>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ count($selectedPermissions) }} / {{ count($permissions) }} selected
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT ACTIONS --}}
        <div class="flex items-center gap-3">
            <a href="{{route('admin.roles')}}"
               class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition text-sm">
                {{ __('Back') }}
            </a>
            <button wire:click="save"
                    class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm shadow-sm">
                {{ __('Save Changes') }}
            </button>
        </div>
    </div>

    {{-- CARD --}}
    <div class="rounded-2xl bg-white p-6">
        @include('livewire.admin._partials.messages.success')
        @include('livewire.admin._partials.messages.error')
        @if(count($permissions))

            {{-- SELECT ALL (Toggle Style) --}}
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input wire:model="selectAll"
                               wire:click="toggleSelectAll"
                               type="checkbox"
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 transition"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition
                            peer-checked:translate-x-5"></div>
                    </div>

                    <span class="text-sm font-medium text-slate-700">
                        {{ $selectAll ? __('Deselect All') : __('Select All') }}
                    </span>
                </label>

                <span class="text-xs text-slate-500">
                    {{ __('Bulk action') }}
                </span>

            </div>
            <hr class="mb-6">
        @endif

        {{-- PERMISSIONS LIST --}}
        @if(count($permissions))
            @include('livewire.admin.teams.roles._partials.permissions')
        @else
            @include('livewire.admin._partials.nodata',['url'=>''])
        @endif
    </div>


    {{-- STICKY FLOATING SAVE BUTTON --}}
    <div class="fixed bottom-6 right-6 z-50">
        <button wire:click="save"
                class="w-14 h-14 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white
                 shadow-xl flex items-center justify-center transition">
            <i class="material-symbols-rounded">save</i>
        </button>
    </div>

</div>
