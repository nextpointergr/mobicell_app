<div  wire:poll.500ms>
    @include('livewire.admin.settings.nav')
    <div class="card overflow-hidden p-6">

        @if (session('warning'))
            <div class="mb-4 rounded-lg bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3">
                {{ session('warning') }}
            </div>
        @endif

        @include('livewire.admin._partials.messages.success')
        @include('livewire.admin._partials.messages.error')
        @include('livewire.admin.settings.smtp.form')

    </div><!-- card overflow-hidden p-6-->


</div><!-- div -->
