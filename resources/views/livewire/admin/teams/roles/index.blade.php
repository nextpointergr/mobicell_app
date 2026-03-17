<div>
    @include('livewire.admin._partials.list-header', [
       'title' => __('Roles'),
       'count' =>$count,
       'icon' => 'admin_panel_settings',
       'subtitle' => __('In this section, you can see all roles.'),
       'addLabel' => __('Add new role'),
       'addUrl' => route('admin.roles.create'),
       'addCan' => 'admin.roles.create',
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
            @include('livewire.admin.teams.roles._partials.data')
        @else
            @include('livewire.admin._partials.nodata' ,['url' => ''])
        @endif

        @if(count($items))
            <div class="mt-5 bg-white">
                {{$items->links()}}
            </div>
        @endif
    </div><!-- card overflow-hidden p-6-->
</div>

