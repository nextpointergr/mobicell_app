<?php

namespace App\Jobs\shop;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Bus;

class DispatchPrestashopFullSyncJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public ?int $userId = null
    ) {
    }

    public function handle(): void
    {
        Bus::chain([
            new DispatchPrestashopGenericSyncJob('categories', $this->userId),
            new DispatchPrestashopGenericSyncJob('carriers', $this->userId),
            new DispatchPrestashopGenericSyncJob('taxes', $this->userId),
            new DispatchPrestashopGenericSyncJob('payments', $this->userId),
            new DispatchPrestashopGenericSyncJob('products', $this->userId),
        ])->dispatch();
    }
}
