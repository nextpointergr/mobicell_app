@php
    $colors = [
        'created' => 'bg-green-100 text-green-700',
        'updated' => 'bg-blue-100 text-blue-700',
        'deleted' => 'bg-red-100 text-red-700',
    ];
@endphp

<tr class="hover:bg-slate-50 transition">

    <td class="px-4 py-3 text-sm text-slate-700">
        {{ $item->causer?->name ?? 'System' }}
    </td>

    <td class="px-4 py-3 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $colors[$item->description] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($item->description) }}
                                    </span>
    </td>

    <td class="px-4 py-3 text-sm text-slate-700">
        {{ class_basename($item->subject_type) }}
        #{{ $item->subject_id }}
    </td>

    <td class="px-4 py-3 text-sm text-slate-500">
        {{ $item->created_at->format('d/m/Y H:i') }}
    </td>

    <td class="px-4 py-3 text-right">
        <button
            wire:click="selectLog({{ $item->id }})"
            class="inline-flex items-center gap-2
               px-3 py-1.5
               rounded-lg
               bg-indigo-50
               text-indigo-600
               text-sm font-medium
               hover:bg-indigo-100
               transition"
        >
            <i class="material-symbols-rounded text-base leading-none">
                visibility
            </i>

            {{ __('View') }}
        </button>
    </td>

</tr>
