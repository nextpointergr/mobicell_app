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

            <button
                wire:click="checkErpConnection({{ $item->id }})"
                wire:loading.attr="disabled"
                class="h-8 w-8 rounded-full bg-blue-100
                       flex items-center justify-center hover:bg-blue-200"
                title="Check ERP"
            >

                <i wire:loading.remove
                   class="material-symbols-rounded text-blue-600">
                    cloud_done
                </i>

                <span wire:loading class="animate-spin text-blue-600 text-xs">
                    ⏳
                </span>

            </button>

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
