<tr
    data-id="{{ $item->id }}"
    class="hover:bg-gray-100">

    @can('admin.employees.sorting')
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


    <td class="px-2 py-2 whitespace-nowrap text-sm">
        {{ $item->email }}
    </td>

    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700">
        @if($item->last_login_at)
            <div class="flex flex-col leading-tight">
                <span class="text-sm text-gray-800">
                    {{ $item->last_login_at->format('d/m/Y') }}
                </span>
                <span class="text-xs text-gray-400">
                        {{ $item->last_login_at->format('H:i') }}
               </span>
            </div>
        @else
            <span class="text-xs text-gray-400 italic">-</span>
        @endif
    </td>


    <td class="px-2 py-2 whitespace-nowrap text-sm">
        @if($item->last_login_ip)
            <div class="flex items-center gap-1.5 text-gray-700">
                <i class="material-symbols-rounded text-base text-gray-400">
                    lan
                </i>
                <span class="font-mono text-xs">
                {{ $item->last_login_ip }}
            </span>
            </div>
        @else
            <span class="text-xs text-gray-400 italic">
            —
        </span>
        @endif
    </td>



    <td class="px-2 py-2 whitespace-nowrap text-sm max-w-xs">
        @if($item->last_login_agent)
            <div class="hs-tooltip relative">
                <div class="flex items-center gap-1.5 text-gray-700">
                    <i class="material-symbols-rounded text-base text-gray-400">
                        devices
                    </i>

                    <span
                        class="font-mono text-xs truncate max-w-[180px]"
                    >
                    {{ $item->last_login_agent }}
                </span>
                </div>

                {{-- TOOLTIP --}}
                <span
                    class="hs-tooltip-content
                       hs-tooltip-shown:opacity-100
                       hs-tooltip-shown:visible
                       opacity-0 invisible
                       transition-opacity
                       absolute z-20
                       left-0 top-full mt-2
                       max-w-md
                       whitespace-normal
                       break-all
                       py-2 px-3
                       bg-gray-900 text-xs text-white
                       rounded-lg shadow-lg"
                    role="tooltip"
                >
                {{ $item->last_login_agent }}
            </span>
            </div>
        @else
            <span class="text-xs text-gray-400 italic">
            —
        </span>
        @endif
    </td>



    @canany(['admin.employees.delete', 'admin.employees.edit','admin.employees.send_again_email'])
        <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium">
            <div class="inline-flex items-center gap-2 justify-end">
                @can('admin.employees.delete')
                    @if($item->canBeDeleted())
                            <a href="{{ route('admin.employees.delete', $item) }}"   data-message="This employee will be deleted!"
                               onclick="confirmDelete(event, this)"
                                class="h-8 w-8 rounded-full bg-gray-200
                                       flex items-center justify-center"><i class="material-symbols-rounded text-xl">
                                    delete
                                </i></a>
                   @endif
                @endcan


                @can('admin.employees.edit')
                        <a href="{{ route('admin.employees.edit', $item) }}"
                            class="h-8 w-8 rounded-full bg-gray-200
                                   flex items-center justify-center"><i class="material-symbols-rounded text-xl">
                                edit
                            </i>
                        </a>
                @endcan


                @can('admin.employees.send_again_email')
                        @if($item->canBeDeleted())
                         <button
                                wire:click="confirmResendPassword({{ $item->id }})"
                                type="button"
                                class="h-8 w-8 rounded-full bg-gray-200
                       flex items-center justify-center"
                            >
                                <i class="material-symbols-rounded text-xl">
                                    mail
                                </i>
                            </button>
                        @endif
                @endcan
            </div>
        </td>
    @endcanany
</tr>

