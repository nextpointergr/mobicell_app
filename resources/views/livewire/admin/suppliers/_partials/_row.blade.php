<tr
    data-id="{{ $item->id }}"
    class="hover:bg-gray-100">

    <td class="px-2 py-2 whitespace-nowrap text-sm">
        {{ $item->id }}
    </td>


    <td class="px-2 py-2 whitespace-nowrap text-sm">
        {{ $item->name }}
    </td>


    @canany(['admin.suppliers.delete', 'admin.suppliers.edit'])
        <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium">
            <div class="inline-flex items-center gap-2 justify-end">
                @can('admin.employees.delete')
                    @if($item->canBeDeleted())
                            <a href="{{ route('admin.suppliers.delete', $item) }}"   data-message="This employee will be deleted!"
                               onclick="confirmDelete(event, this)"
                                class="h-8 w-8 rounded-full bg-gray-200
                                       flex items-center justify-center"><i class="material-symbols-rounded text-xl">
                                    delete
                                </i></a>
                   @endif
                @endcan


                @can('admin.suppliers.edit')
                        <a href="{{ route('admin.suppliers.edit', $item) }}"
                            class="h-8 w-8 rounded-full bg-gray-200
                                   flex items-center justify-center"><i class="material-symbols-rounded text-xl">
                                edit
                            </i>
                        </a>
                @endcan

                    @can('admin.suppliers.mapping')
                        <a href="{{ route('admin.suppliers.mapping', $item) }}"
                           class="h-8 w-8 rounded-full bg-gray-200
                                   flex items-center justify-center"><i class="material-symbols-rounded text-xl">
                                mapping
                            </i>
                        </a>
                    @endcan
            </div>
        </td>
    @endcanany
</tr>

