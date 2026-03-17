<div>

    @include('livewire.admin._partials.list-header', [
        'title' => __('Logs'),
        'count' => $count,
        'icon' => 'fact_check',
        'subtitle' => __('System activity & audit trail overview.'),
        'addLabel' => null,
        'addUrl' => null,
        'addCan' => null,
    ])

    @if($items->count())
        @include('livewire.admin.system.logs._partials.stats')
        @include('livewire.admin.system.logs._partials.filters')
        <div class="card overflow-hidden p-6">
            @include('livewire.admin._partials.messages.success')
            @include('livewire.admin._partials.messages.error')
            @include('livewire.admin.system.logs._partials.data')
            <div class="mt-6">
                    {{ $items->links() }}
            </div>
        </div>
        @include('livewire.admin.system.logs._partials.details-modal')
    @else
        <div class="card overflow-hidden p-6">
            @include('livewire.admin._partials.nodata' ,['url' => ''])
        </div>
    @endif
</div>
