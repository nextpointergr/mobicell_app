<?php

namespace App\Traits;

use App\Models\ShopData;
use Illuminate\Support\Facades\DB;

trait HandlesShopSync
{
    public function performUpsert(string $source, string $type, array $items): int
    {
        $now = now();
        $upsertData = [];
        $processedCount = 0;

        // Παίρνουμε όλα τα υπάρχοντα hashes για αυτό το source/type για να συγκρίνουμε στη μνήμη (γρήγορο)
        $existingHashes = ShopData::where('source', $source)
            ->where('type', $type)
            ->whereIn('external_id', array_column($items, 'id'))
            ->pluck('hash', 'external_id')
            ->toArray();

        foreach ($items as $item) {
            $externalId = (string)$item['id'];
            $payload = json_encode($item);
            $newHash = md5($payload);
            if (isset($existingHashes[$externalId]) && $existingHashes[$externalId] === $newHash) {
                continue;
            }

            $upsertData[] = [
                'source'         => $source,
                'type'           => $type,
                'external_id'    => $externalId,
                'hash'           => $newHash,
                'payload'        => $payload,
                'last_synced_at' => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ];

            $processedCount++;
        }

        if (!empty($upsertData)) {
            ShopData::upsert(
                $upsertData,
                ['source', 'type', 'external_id'],
                ['hash', 'payload', 'last_synced_at', 'updated_at']
            );
        }

        return $processedCount;
    }
}
