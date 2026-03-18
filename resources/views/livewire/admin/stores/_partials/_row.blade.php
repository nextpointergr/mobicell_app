<tr class="hover:bg-gray-100">

    {{-- ID --}}
    <td class="px-2 py-2 text-sm text-gray-800">
        {{ $item->id }}
    </td>

    {{-- NAME --}}
    <td class="px-2 py-2 text-sm text-gray-800">
        <div class="flex flex-col">
            <span>{{ $item->name }}</span>
            <span class="text-xs text-gray-400">{{ $item->slug }}</span>
        </div>
    </td>

    {{-- EMAIL --}}
    <td class="px-2 py-2 text-sm text-gray-700">
        {{ $item->email ?? '-' }}
    </td>

    {{-- ACTIVE SWITCH --}}
    <td class="px-2 py-2 text-sm">
        <label class="inline-flex items-center cursor-pointer">
            <input
                type="checkbox"
                wire:click="toggleActive({{ $item->id }})"
                @checked($item->active)
                class="sr-only peer"
            >

            <div class="w-10 h-5 bg-gray-200 rounded-full peer
                        peer-checked:bg-green-500
                        relative transition">

                <div class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full
                            transition
                            peer-checked:translate-x-5">
                </div>
            </div>
        </label>
    </td>

    {{-- ERP CHECK --}}
    <td class="px-2 py-2 text-sm">
        @if($item->hasPylon())
            <div class="relative flex items-center justify-center group/tooltip">

                <div class="absolute bottom-full mb-3 flex flex-col items-center opacity-0 translate-y-2 group-hover/tooltip:opacity-100 group-hover/tooltip:translate-y-0 transition-all duration-300 pointer-events-none z-50">
        <span class="px-3 py-1.5 text-[11px] font-medium text-white bg-slate-900/90 backdrop-blur-sm shadow-xl rounded-lg whitespace-nowrap">
            Έλεγχος Σύνδεσης ERP
        </span>
                    <div class="w-2 h-2 -mt-1 rotate-45 bg-slate-900/90"></div>
                </div>

                <button
                    wire:click="checkErpConnection({{ $item->id }})"
                    wire:loading.attr="disabled"
                    class="group relative h-11 w-11 flex items-center justify-center rounded-2xl
               bg-white border border-slate-200/60 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.07)]
               hover:border-blue-400 hover:shadow-blue-100 hover:shadow-lg
               transition-all duration-500 active:scale-90
               disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden"
                >
                    <svg wire:loading.remove
                         class="w-5 h-5 text-slate-500 group-hover:text-blue-600 transition-all duration-300 group-hover:scale-110"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5c-4.418 0-8 1.343-8 3s3.582 3 8 3 8-1.343 8-3-3.582-3-8-3z"></path>
                        <path d="M4 8v6c0 1.657 3.582 3 8 3 1.124 0 2.185-.087 3.153-.245"></path>
                        <path d="M20 12.5V8"></path>
                        <path class="text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity" d="M19 15l-3 3h-3l-2 2"></path>
                        <path d="M16 20l3-3"></path>
                    </svg>

                    <svg wire:loading
                         class="animate-spin h-5 w-5 text-blue-500"
                         viewBox="0 0 24 24">
                        <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"></circle>
                        <path class="opacity-80" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <span class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                </button>
            </div>

        @else
            <span class="text-xs text-gray-400 italic">
                Not configured
            </span>
        @endif
    </td>

    {{-- ACTIONS --}}
    @canany(['admin.stores.delete', 'admin.stores.edit'])
        <td class="px-2 py-2 text-end text-sm font-medium">
            <div class="inline-flex items-center gap-2 justify-end">

                {{-- DELETE --}}
                @can('admin.stores.delete')
                    @if($item->canBeDeleted())
                        <a href="{{ route('admin.stores.delete', $item) }}"
                           data-message="This store will be deleted!"
                           onclick="confirmDelete(event, this)"
                           class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">

                            <i class="material-symbols-rounded text-xl">
                                delete
                            </i>
                        </a>
                    @endif
                @endcan

                {{-- EDIT --}}
                @can('admin.stores.edit')
                    <a href="{{ route('admin.stores.edit', $item) }}"
                       class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">

                        <i class="material-symbols-rounded text-xl">
                            edit
                        </i>
                    </a>
                @endcan

            </div>
        </td>
    @endcanany

</tr>
