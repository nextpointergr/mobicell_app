

<div>
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        @can('admin.roles.sorting')
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            </th>
                        @endcan

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Name') }}
                        </th>
                        @canany(['admin.roles.delete', 'admin.roles.edit','admin.roles.permissions'])
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
                        @include('livewire.admin.teams.roles._partials._row', ['item' => $item])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@can('admin.roles.sorting')
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

                            wire.reorderRoles(ids);
                        }
                    });
                }
            }));
        });
    </script>
@endcan
