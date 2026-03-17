<div  wire:poll.500ms>
    @include('livewire.admin.settings.nav', [ 'user' => auth()->user()])
    <div class="card overflow-hidden p-6">
        @include('livewire.admin._partials.messages.success')
        @include('livewire.admin._partials.messages.error')
        @include('livewire.admin.settings.api.form')


    </div><!-- card overflow-hidden p-6-->
</div>
