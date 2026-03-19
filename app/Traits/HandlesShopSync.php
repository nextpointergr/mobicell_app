<?php

namespace App\Traits;

use App\Models\ExternalSync;
use App\Models\ShopData;
use App\Models\SyncRun;
use App\Models\SyncRunLog;
use Throwable;

trait HandlesShopSync
{
    protected function normalizeItem(array $item): array
    {
        ksort($item);

        foreach ($item as $key => $value) {
            if (is_array($value)) {
                $item[$key] = $this->normalizeItem($value);
            }
        }

        return $item;
    }

    protected function makePayloadAndHash(array $item): array
    {
        $normalized = $this->normalizeItem($item);

        $payload = json_encode(
            $normalized,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return [$payload, md5($payload)];
    }

    protected function logAction(
        SyncRun $run,
        string $entity,
        string $action,
        ?string $externalId = null,
        ?string $message = null,
        ?array $oldPayload = null,
        ?array $newPayload = null,
        string $status = 'success'
    ): void {
        SyncRunLog::create([
            'sync_run_id' => $run->id,
            'source' => 'prestashop',
            'entity' => $entity,
            'external_id' => $externalId,
            'action' => $action,
            'status' => $status,
            'message' => $message,
            'old_payload' => $oldPayload,
            'new_payload' => $newPayload,
            'created_at' => now(),
        ]);
    }

    protected function syncChunk(
        string $source,
        string $type,
        array $items,
        SyncRun $run
    ): array {
        $now = now();

        $incomingIds = collect($items)
            ->pluck('id')
            ->filter()
            ->map(fn ($id) => (string) $id)
            ->values()
            ->all();

        $existingRows = ShopData::withTrashed()
            ->where('source', $source)
            ->where('type', $type)
            ->whereIn('external_id', $incomingIds)
            ->get()
            ->keyBy('external_id');

        $inserts = [];
        $updates = [];

        $stats = [
            'processed' => count($items),
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'restored' => 0,
            'errors' => 0,
        ];

        foreach ($items as $item) {
            try {
                $externalId = isset($item['id']) ? (string) $item['id'] : null;

                if (!$externalId) {
                    $stats['errors']++;
                    continue;
                }

                [$payload, $hash] = $this->makePayloadAndHash($item);

                $existing = $existingRows->get($externalId);

                // 🟢 CREATE
                if (!$existing) {
                    $inserts[] = [
                        'source' => $source,
                        'type' => $type,
                        'external_id' => $externalId,
                        'hash' => $hash,
                        'payload' => $payload,
                        'last_synced_at' => $now,
                        'last_seen_at' => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                        'deleted_at' => null,
                    ];

                    $stats['created']++;

                    $this->logAction($run, $type, 'created', $externalId, null, null, $item);
                    continue;
                }

                $oldPayload = is_array($existing->payload)
                    ? $existing->payload
                    : json_decode($existing->payload, true);

                $wasDeleted = $existing->deleted_at !== null;
                $hashChanged = $existing->hash !== $hash;

                // 🔁 SKIP
                if (!$hashChanged && !$wasDeleted) {
                    // 👇 ΣΗΜΑΝΤΙΚΟ: update last_seen_at
                    ShopData::where('id', $existing->id)
                        ->update(['last_seen_at' => $now]);

                    $stats['skipped']++;
                    continue;
                }

                $updates[] = [
                    'source' => $source,
                    'type' => $type,
                    'external_id' => $externalId,
                    'hash' => $hash,
                    'payload' => $payload,
                    'last_synced_at' => $now,
                    'last_seen_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ];

                if ($wasDeleted) {
                    $stats['restored']++;

                    $this->logAction(
                        $run,
                        $type,
                        'restored',
                        $externalId,
                        null,
                        $oldPayload,
                        $item
                    );
                } else {
                    $stats['updated']++;

                    $this->logAction(
                        $run,
                        $type,
                        'updated',
                        $externalId,
                        null,
                        $oldPayload,
                        $item
                    );
                }
            } catch (Throwable $e) {
                $stats['errors']++;
            }
        }

        if (!empty($inserts)) {
            ShopData::insert($inserts);
        }

        if (!empty($updates)) {
            ShopData::upsert(
                $updates,
                ['source', 'type', 'external_id'],
                ['hash', 'payload', 'last_synced_at', 'last_seen_at', 'updated_at', 'deleted_at']
            );
        }

        return [$incomingIds, $stats];
    }

    // 🔥 NEW SAFE DELETE (NO MORE BUGS)
    protected function safeDelete(string $source, string $type, SyncRun $run): int
    {
        $toDelete = ShopData::where('source', $source)
            ->where('type', $type)
            ->whereNull('deleted_at')
            ->where('last_seen_at', '<', $run->started_at)
            ->get();

        foreach ($toDelete as $row) {
            $oldPayload = is_array($row->payload)
                ? $row->payload
                : json_decode($row->payload, true);

            $this->logAction(
                $run,
                $type,
                'deleted',
                (string)$row->external_id,
                null,
                $oldPayload,
                null
            );
        }

        $count = count($toDelete);

        if ($count > 0) {
            ShopData::whereIn('id', $toDelete->pluck('id'))
                ->delete();
        }

        return $count;
    }

    protected function incrementRunStats(SyncRun $run, array $stats): void
    {
        $run->increment('processed', $stats['processed'] ?? 0);
        $run->increment('created', $stats['created'] ?? 0);
        $run->increment('updated', $stats['updated'] ?? 0);
        $run->increment('skipped', $stats['skipped'] ?? 0);
        $run->increment('restored', $stats['restored'] ?? 0);
        $run->increment('errors', $stats['errors'] ?? 0);
    }

    protected function finishRun(SyncRun $run, string $entity): void
    {
        ExternalSync::updateOrCreate(
            ['source' => 'prestashop', 'entity' => $entity],
            ['last_synced_at' => now()]
        );

        $run->update([
            'status' => 'completed',
            'finished_at' => now(),
        ]);
    }


    protected function failRun(SyncRun $run, Throwable $e): void
    {
        $run->update([
            'status' => 'failed',
            'finished_at' => now(),
            'error_message' => $e->getMessage(),
        ]);

        $this->logAction(
            run: $run,
            entity: $run->entity,
            action: 'failed',
            externalId: null,
            message: $e->getMessage(),
            status: 'error'
        );
    }

    protected function buildPrestashopQuery(
        string $entity,
        int $limit,
        int $offset,
        ?string $since = null,
        ?string $until = null
    ) {
        $query = match ($entity) {
            'categories' => \Nextpointer\Prestashop\Facades\Prestashop::categories(),
            'carriers'   => \Nextpointer\Prestashop\Facades\Prestashop::carriers(),
            'payments'   => \Nextpointer\Prestashop\Facades\Prestashop::payments(),
            'taxes'      => \Nextpointer\Prestashop\Facades\Prestashop::taxes(),
            'products'   => \Nextpointer\Prestashop\Facades\Prestashop::products(),
            default => throw new \InvalidArgumentException("Unsupported entity"),
        };

        $query = $query
            ->limit($limit)
            ->offset($offset);

        if ($since) {
            $query = $query->since($since);
        }

        if ($until) {
            $query = $query->until($until);
        }

        return $query;
    }
}
