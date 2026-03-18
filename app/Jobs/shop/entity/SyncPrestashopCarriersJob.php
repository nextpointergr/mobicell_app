<?php



namespace App\Jobs\shop\entity;

use App\Models\ExternalSync;
use App\Models\SyncRun;

use App\Traits\HandlesShopSync;
use App\Events\SyncProgressUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Nextpointer\Prestashop\Facades\Prestashop;

class SyncPrestashopCarriersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HandlesShopSync;

    public $tries = 3;
    public $timeout = 120;

    /**
     * @param int $runId Το ID της εγγραφής SyncRun για το tracking
     */
    public function __construct(
        public int $runId,
        public int $offset = 0,
        public int $limit = 100, // Μικρότερο limit για κατηγορίες/shipping
        public ?string $since = null
    ) {}

    public function handle(): void
    {
        $run = SyncRun::findOrFail($this->runId);
        if ($run->status !== 'running') return;


        $response = Prestashop::carriers()
            ->limit($this->limit)
            ->offset($this->offset)
            ->since($this->since ?? '')
            ->get();

        $items = $response['data'] ?? [];
        $meta = $response['meta'] ?? [];
        $hasMore = (bool)($meta['has_more'] ?? false);

        if (empty($items)) {
            $this->finish($run);
            return;
        }

        $this->performUpsert('prestashop', 'carriers', $items);
        $run->increment('processed', count($items));

        event(new SyncProgressUpdated(
            entity: 'carriers',
            processed: $run->processed,
            runId: $run->id,completed: false
        ));

        if ($hasMore) {
            self::dispatch(
                runId: $this->runId,
                offset: $this->offset + $this->limit,
                limit: $this->limit,
                since: $this->since
            )->onQueue('prestashop');
        } else {
            $this->finish($run);
        }
    }

    private function finish(SyncRun $run): void
    {
        // Ενημέρωση ημερομηνίας τελευταίου συγχρονισμού
        ExternalSync::updateOrCreate(
            ['source' => 'prestashop', 'entity' => 'carriers'],
            ['last_synced_at' => now()]
        );

        $run->update([
            'status' => 'completed',
            'finished_at' => now(),
        ]);

        event(new SyncProgressUpdated(
            entity: 'carriers',
            processed: $run->processed,
            runId: $run->id,
            completed: true
        ));
    }
}
