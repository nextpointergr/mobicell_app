

<div>
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>

                        <th class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('ID') }}
                        </th>

                        <th class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Name') }}
                        </th>

                        <th class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Email') }}
                        </th>

                        <th class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Active') }}
                        </th>

                        <th class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('ERP') }}
                        </th>

                        @canany(['admin.stores.delete', 'admin.stores.edit'])
                            <th class="px-2 py-2 text-end text-sm text-gray-500">
                                {{ __('Actions') }}
                            </th>
                        @endcanany

                    </tr>
                    </thead>

                    <tbody
                        class="divide-y divide-gray-200"
                    >
                    @foreach($items as $item)
                        @include('livewire.admin.stores._partials._row', ['item' => $item])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

