<?php

namespace App\Jobs\shop;
use App\Jobs\shop\entity\SyncPrestashopCarriersJob;
use App\Jobs\shop\entity\SyncPrestashopPaymentsJob;
use App\Jobs\shop\entity\SyncPrestashopProductsJob;
use App\Jobs\shop\entity\SyncPrestashopTaxesJob;
use App\Models\ExternalSync;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\SyncRun;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\shop\entity\SyncPrestashopCategoriesJob;


class DispatchPrestashopGenericSyncJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public string $entity) {}

    public function handle(): void
    {
        $run = SyncRun::create([
            'source'    => 'prestashop',
            'entity'    => $this->entity,
            'direction' => 'import',
            'status'    => 'running',
            'started_at' => now(),
        ]);

        $sync = ExternalSync::firstOrCreate([
            'source' => 'prestashop',
            'entity' => $this->entity,
        ]);

        $since = null;
        if ($this->entity === 'products') {
            $since = $sync->last_synced_at?->format('Y-m-d H:i:s');
        }

        $workerClass = match($this->entity) {
            'categories' => SyncPrestashopCategoriesJob::class,
            'carriers' => SyncPrestashopCarriersJob::class,
            'taxes' => SyncPrestashopTaxesJob::class,
            'payments' => SyncPrestashopPaymentsJob::class,
            'products' => SyncPrestashopProductsJob::class,
            default      => null
        };
        if ($workerClass) {
            $workerClass::dispatch(
                runId: $run->id,
                offset: 0,
                limit: 100,
                since: $since
            )->onQueue('prestashop');
        }
    }
}
