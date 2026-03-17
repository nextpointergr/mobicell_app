<form wire:submit.prevent="save" class="mt-5">
    <div class="col-span-3">
        <div class="space-y-2">
            <div class="flex flex-col gap-3">
                @foreach($permissions as $permission)
                    <div class="flex items-center gap-2">
                        <input
                            wire:model="selectedPermissions" class="form-switch"
                            role="switch"
                            type="checkbox"
                            value="{{ $permission->name }}"
                            id="permission_{{ $permission->id }}"
                            class="form-check-input"
                        >

                        <label for="permission_{{ $permission->id }}" class="ms-1.5">
                            @if(!empty($permission->label))
                                {{$permission->label}}
                            @else
                                {{ ucfirst($permission->name) }}
                            @endif

                        </label> <!-- ms-1.5-->
                    </div><!-- flex items-center gap-2-->
                @endforeach
            </div><!-- flex flex-col gap-3-->
        </div><!-- space-y-2-->

        @error('selectedPermissions')
                <span class="text-red-500 text-xs font-medium mt-5">
                    {{ $message }}
                </span><!-- text-red-500 text-xs font-medium mt-5-->
        @enderror
    </div><!-- col-span-3-->


</form><!-- form -->
