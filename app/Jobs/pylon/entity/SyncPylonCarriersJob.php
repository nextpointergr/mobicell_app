<?php

namespace App\Jobs\pylon\entity;

use App\Models\ExternalSync;
use App\Models\SyncRun;
use App\Traits\HandlesErpSync;
use App\Events\SyncProgressUpdated;
use App\Services\PylonManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use NextPointer\Pylon\Facades\Pylon;

class SyncPylonCarriersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HandlesErpSync;

    public function __construct(
        public int $runId,
        public int $page = 1,
        public int $size = 250, // Μεγάλο size για να τελειώνουμε γρήγορα
        public array $processedIds = []
    ) {}

    public function handle(): void
    {
        $run = SyncRun::findOrFail($this->runId);
        if ($run->status !== 'running') return;

        $pylon = Pylon::store(central_store_slug());

        // Καλούμε το resource δυναμικά ή στατικά (εδώ payments)
        $dtos = $pylon->shipping()->all($this->page, $this->size)->dto();

        // --- ΕΔΩ ΕΙΝΑΙ Ο ΕΛΕΓΧΟΣ ΤΕΛΟΥΣ ---
        if (empty($dtos)) {
            $this->cleanupMissingEntities('carriers', $this->processedIds);
            $this->finish($run);
            return;
        }

        // Επεξεργασία και αποθήκευση των IDs
        $currentPageIds = $this->performMultiStoreUpsert('carriers', $dtos);
        $this->processedIds = array_merge($this->processedIds, $currentPageIds);

        $run->increment('processed', count($dtos));

        event(new SyncProgressUpdated(
            entity: 'carriers',
            processed: $run->processed,
            runId: $run->id,
            completed: false
        ));

        // Dispatch την επόμενη σελίδα
        self::dispatch(
            $this->runId,
            $this->page + 1,
            $this->size,
            $this->processedIds
        )->onQueue('pylon');
    }

    private function finish(SyncRun $run): void
    {
        // Ενημέρωση ημερομηνίας τελευταίου συγχρονισμού
        ExternalSync::updateOrCreate(
            ['source' => 'pylon', 'entity' => 'carriers'],
            ['last_synced_at' => now()]
        );

        $run->update(['status' => 'completed', 'finished_at' => now()]);
        event(new SyncProgressUpdated(entity: 'carriers', processed: $run->processed, runId: $run->id, completed: true));
    }
}
