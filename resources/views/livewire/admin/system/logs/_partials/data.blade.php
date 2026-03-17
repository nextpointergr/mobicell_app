<div>
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                   <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Employee') }}
                            </th>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Action') }}
                            </th>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Target') }}
                            </th>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Date') }}
                            </th>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($items as $item)
                            @include('livewire.admin.system.logs._partials._row', ['item' => $item])
                        @endforeach
                    </tbody>
                </table>
</div>
        </div>
    </div>
</div>
