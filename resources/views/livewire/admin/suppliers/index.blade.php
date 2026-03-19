<div>
    @include('livewire.admin._partials.list-header', [
        'title' => __('Suppliers'),
        'count' =>$count,
        'icon' => 'Engineering',
        'subtitle' => __('In this section, you can see all suppliers.'),
        'addLabel' => __('Add new employee'),
        'addUrl' => route('admin.suppliers.create'),
        'addCan' => 'admin.suppliers.create',
     ])

    <div class="card overflow-hidden p-6">
        @if($count)
            <div class="flex mb-5">
                @include('livewire.admin._partials.search')
            </div>
        @endif

        @include('livewire.admin._partials.messages.success')
        @include('livewire.admin._partials.messages.error')

        @if(count($items))
            @include('livewire.admin.suppliers._partials.data')
        @else
            @include('livewire.admin._partials.nodata' ,['url' => ''])
        @endif

        @if(count($items))
            <div class="mt-5 bg-white">
                {{$items->links()}}
            </div>
        @endif
    </div>
</div>
