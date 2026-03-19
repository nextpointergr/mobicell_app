<?php

namespace App\Jobs\shop;

use App\Events\SyncProgressUpdated;
use App\Models\SyncRun;
use App\Traits\HandlesShopSync;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SyncPrestashopEntityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HandlesShopSync;

    public int $tries = 3;
    public int $timeout = 1800;

    public function __construct(
        public int $runId,
        public string $entity,
        public int $limit = 200,
        public ?string $since = null,
            public ?string $until = null
    ) {
    }

    public function handle(): void
    {
        $run = SyncRun::findOrFail($this->runId);

        if ($run->status !== 'running') {
            return;
        }

        try {
            $offset = 0;

            $source = 'prestashop';

            do {
                $response = $this->buildPrestashopQuery(
                    entity: $this->entity,
                    limit: $this->limit,
                    offset: $offset,
                    since: $this->since,
                      until: $this->until
                )->get();

                $items = $response['data'] ?? [];
                $meta = $response['meta'] ?? [];
                $hasMore = count($items) === $this->limit;


                if (!empty($items)) {
                    [, $stats] = $this->syncChunk(
                        source: $source,
                        type: $this->entity,
                        items: $items,
                        run: $run
                    );


                    $this->incrementRunStats($run, $stats);
                }

                event(new SyncProgressUpdated(
                    entity: $this->entity,
                    processed: $run->fresh()->processed,
                    runId: $run->id,
                    completed: false
                ));

                $offset += $this->limit;
            } while ($hasMore);

            // ΜΟΝΟ full sync entities κάνουν delete detection
            if ($this->entity !== 'products') {
                $deleted = $this->safeDelete('prestashop', $this->entity, $run);

                if ($deleted > 0) {
                    $this->incrementRunStats($run, [
                        'deleted' => $deleted,
                    ]);
                }
            }

            $this->finishRun($run, $this->entity);

            event(new SyncProgressUpdated(
                entity: $this->entity,
                processed: $run->fresh()->processed,
                runId: $run->id,
                completed: true
            ));
        } catch (Throwable $e) {
            $this->failRun($run, $e);
            throw $e;
        }
    }
}
