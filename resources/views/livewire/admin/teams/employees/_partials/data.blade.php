

<div>
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        @can('admin.employees.sorting')
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            </th>
                        @endcan

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Name') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Email') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Last Login') }}
                        </th>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('IP') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Login agent') }}
                            </th>

                        @canany(['admin.employees.delete', 'admin.employees.edit'])
                            <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                                {{ __('Actions') }}</th>
                        @endcanany
                    </tr>
                    </thead>

                    <tbody
                        x-data="sortableTable($wire)"
                        class="divide-y divide-gray-200"
                    >
                    @foreach($items as $item)
                        @include('livewire.admin.teams.employees._partials._row', ['item' => $item])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@can('admin.employees.sorting')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sortableTable', (wire) => ({
                init() {
                    new Sortable(this.$el, {
                        handle: '[data-drag-handle]',
                        animation: 150,
                        onEnd: () => {
                            const ids = [...this.$el.querySelectorAll('[data-id]')]
                                .map(el => el.dataset.id);

                            wire.reorderEmployees(ids);
                        }
                    });
                }
            }));
        });
    </script>
@endcan
