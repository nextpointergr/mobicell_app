<div>
    @include('livewire.admin._partials.list-header', [
        'title' => __('Employees'),
        'count' =>$count,
        'icon' => 'Engineering',
        'subtitle' => __('In this section, you can see all employees.'),
        'addLabel' => __('Add new employee'),
        'addUrl' => route('admin.employees.create'),
        'addCan' => 'admin.employees.create',
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
            @include('livewire.admin.teams.employees._partials.data')
        @else
            @include('livewire.admin._partials.nodata' ,['url' => ''])
        @endif

        @if(count($items))
            <div class="mt-5 bg-white">
                {{$items->links()}}
            </div>
        @endif
    </div>


    @if($confirmingResendId)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">

                <h2 class="text-lg font-semibold mb-4">
                    {{ __('Are you sure?') }}
                </h2>

                <p class="text-sm text-gray-600 mb-6">
                    {{ __('This will generate a new password and send it via email.') }}
                </p>

                <div class="flex justify-end gap-3">
                    <button
                        wire:click="$set('confirmingResendId', null)"
                        class="px-4 py-2 bg-gray-200 rounded-lg"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        wire:click="resendPassword"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg"
                    >
                        {{ __('Yes, send it') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
