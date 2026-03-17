<div>
    @include('livewire.admin._partials.list-header', [
        'title' => __('Stores'),
        'count' =>$count,
        'icon' => 'Store',
        'subtitle' => __('In this section, you can see all employees.'),
        'addLabel' => __('Add new store'),
        'addUrl' => route('admin.stores.create'),
        'addCan' => 'admin.stores.create',
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
            @include('livewire.admin.stores._partials.data')
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
