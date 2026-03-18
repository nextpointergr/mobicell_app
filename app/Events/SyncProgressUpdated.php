<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SyncProgressUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $entity,
        public int $processed,
        public int $runId,
        public bool $completed = false
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('sync');
    }

    public function broadcastAs(): string
    {
        return 'sync.progress';
    }

    public function broadcastWith(): array
    {
        return [
            'entity'    => $this->entity,
            'processed' => $this->processed,
            'runId'     => $this->runId,
            'completed' => $this->completed,
        ];
    }
}
