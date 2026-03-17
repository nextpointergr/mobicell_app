<tr
    data-id="{{ $item->id }}"
    class="hover:bg-gray-100"
>
    {{-- SORT HANDLE --}}
    @can('admin.roles.sorting')
        <td class="px-2 py-2 text-sm text-gray-800">
            <span
                data-drag-handle
                class="group inline-flex items-center justify-center
                       h-7 w-7 rounded-lg
                       bg-slate-100
                       text-slate-400
                       cursor-grab
                       transition
                       hover:bg-slate-200 hover:text-slate-600
                       active:cursor-grabbing"
            >
                <i class="material-symbols-rounded text-base">
                    drag_indicator
                </i>
            </span>
        </td>
    @endcan

    <td class="px-2 py-2 whitespace-nowrap text-sm">
        {{ $item->name }}
    </td>

    @canany(['admin.roles.delete', 'admin.roles.edit','admin.roles.permissions'])
        <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium">
            <div class="inline-flex items-center gap-2 justify-end">
                @can('admin.roles.delete')
                    @if($item->canBeDeleted())
                        <a href="{{ route('admin.roles.delete', $item) }}"   data-message="This role will be deleted!"
                           onclick="confirmDelete(event, this)"
                                class="h-8 w-8 rounded-full bg-gray-200
                                       flex items-center justify-center">
                                <i class="material-symbols-rounded text-xl">
                                    delete
                                </i>
                        </a>

                    @endif
                @endcan
                @can('admin.roles.edit')
                    <a href="{{ route('admin.roles.edit', $item) }}"
                            class="h-8 w-8 rounded-full bg-gray-200
                                   flex items-center justify-center">
                            <i class="material-symbols-rounded text-xl">
                                edit
                            </i>
                     </a>
                @endcan
                @can('admin.roles.permissions')
                    <a href="{{ route('admin.roles.permissions', $item) }}" data-fc-placement="bottom"
                     class=" h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center" >
                                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">
                                    settings
                                </i>
                    </a>
                @endcan
            </div>
        </td>
    @endcanany
</tr>
