<?php

namespace App\Jobs\shop;

use App\Jobs\shop\SyncPrestashopEntityJob;
use App\Models\ExternalSync;
use App\Models\SyncRun;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class DispatchPrestashopGenericSyncJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $tries = 1;
    public int $timeout = 120;

    public function __construct(
        public string $entity,
        public ?int $userId = null
    ) {
    }

    public function handle(): void
    {
        $run = SyncRun::create([
            'source' => 'prestashop',
            'entity' => $this->entity,
            'direction' => 'import',
            'status' => 'running',
            'started_at' => now(),
            'user_id' => $this->userId,
        ]);

        $sync = ExternalSync::firstOrCreate([
            'source' => 'prestashop',
            'entity' => $this->entity,
        ]);

        $since = null;
        $until = null;

        if ($this->entity === 'products') {
            $since = $sync->last_synced_at?->format('Y-m-d H:i:s');
            $until = now()->format('Y-m-d H:i:s');
        }

        SyncPrestashopEntityJob::dispatch(
            runId: $run->id,
            entity: $this->entity,
            limit: $this->entity === 'products' ? 200 : 1000,
            since: $since,
               until: $until
        )->onQueue('prestashop');
    }
}
