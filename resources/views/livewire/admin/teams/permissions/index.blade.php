
<div class="card overflow-hidden p-6">
    <div class="bg-white rounded-2xl">
        <h2 class="text-lg font-semibold mb-4">
          {{ __('Permission Synchronization') }}
        </h2>

        <div class="flex items-center gap-4">
            <button
                wire:click="syncPermissions"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2
                    px-7 py-3
                    rounded-lg
                    text-sm font-semibold
                    shadow-md
                    transition bg-slate-900 text-white hover:bg-slate-800 hover:shadow-lg
               disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>

                <svg
                    wire:loading
                    wire:target="syncPermissions"
                    class="w-4 h-4 animate-spin"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                    ></path>
                </svg>

                <span wire:loading.remove wire:target="syncPermissions">
            {{ __('Sync Permissions') }}
        </span>

                     <span wire:loading wire:target="syncPermissions">
                            {{ __('Syncing...') }}
                    </span>
            </button>
        </div>

        <div class="mt-6 rounded-xl border border-dashed border-amber-300 bg-amber-50 p-4 text-sm text-amber-900">
            <p class="font-semibold mb-2">
                {{ __('Developer Note (Internal Use Only)') }}
            </p>
            <p>
                {{ __('Add new permissions inside') }}
                <code class="px-1 py-0.5 bg-amber-100 rounded text-xs">
                    {{ __('config/system_permissions.php') }}
                </code>
                {{ __('by extending the permissions array.') }}
            </p>
            <p class="mt-2">
                {{ __('The system automatically scans routes and registers permissions
               defined either in routes or in the config file.') }}
            </p>
            <p class="mt-2">
                {!! __('After adding or modifying a permission (via route or config), click the <strong>:button</strong> button above or run the following command:', [
                    'button' => 'Sync Permissions'
                ]) !!}
            </p>
            <div class="mt-2">
                <code class="px-2 py-1 bg-black text-white rounded text-xs">
                    {{ __('php artisan db:seed') }}
                </code>
            </div>
        </div>
    </div>
</div>
