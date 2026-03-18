<?php

namespace App\Jobs\pylon;

use App\Models\SyncRun;
use App\Models\ExternalSync;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Pylon\Entity\SyncPylonPaymentsJob;
use App\Jobs\Pylon\Entity\SyncPylonCarriersJob;
use App\Jobs\Pylon\Entity\SyncPylonCategoriesJob;
// κλπ...

class DispatchPylonGenericSyncJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public string $entity) {}

    public function handle(): void
    {
        $run = SyncRun::create([
            'source'    => 'pylon',
            'entity'    => $this->entity,
            'direction' => 'import',
            'status'    => 'running',
            'started_at' => now(),
        ]);

        $workerClass = match($this->entity) {
            'payments' => SyncPylonPaymentsJob::class,
//            'carriers' => SyncPylonCarriersJob::class,
//            'categories' => SyncPylonCategoriesJob::class,
            default    => null
        };

        if ($workerClass) {
            $workerClass::dispatch(
                runId: $run->id,
                page: 1,
                size: 500
            )->onQueue('pylon');
        }
    }
}
