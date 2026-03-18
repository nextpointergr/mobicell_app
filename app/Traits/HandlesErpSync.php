<?php

namespace App\Traits;

use App\Models\Entity;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

trait HandlesErpSync
{
    public function performMultiStoreUpsert(string $type, array $dtos): array
    {
        $now = now();
        $dbIds = [];

        // Caching Store IDs για να μην κάνουμε queries μέσα στο loop
        $stores = Store::whereIn('slug', [central_store_slug(), 'elliniko'])
            ->pluck('id', 'slug');

        DB::transaction(function () use ($dtos, $type, $stores, $now, &$dbIds) {
            foreach ($dtos as $dto) {
                // Lookup Key: SKU για προϊόντα, Name για τα υπόλοιπα
                $lookupKey = $dto->sku ?? $dto->name ?? null;
                if (!$lookupKey) continue;

                // 1. Master Entity Upsert
                $entity = Entity::updateOrCreate(
                    ['lookup_key' => (string)$lookupKey, 'type' => $type],
                    [
                        'name'   => $dto->name ?? $lookupKey,
                        'active' => true,
                        'hash'   => md5(json_encode($dto)),
                        'updated_at' => $now
                    ]
                );

                $dbIds[] = $entity->id;

                // 2. Dynamic Mapping για όλα τα Stores
                $mappings = [
                    central_store_slug() => $dto->centralId ?? null,
                    'elliniko'           => $dto->ellinikoId ?? null,
                ];

                foreach ($mappings as $slug => $erpId) {
                    if ($erpId && isset($stores[$slug])) {
                        $entity->storeValues()->updateOrCreate(
                            ['store_id' => $stores[$slug]],
                            ['erp_id'   => (string)$erpId]
                        );
                    }
                }
            }
        });

        return $dbIds;
    }

    public function cleanupMissingEntities(string $type, array $processedIds): void
    {
        // Απενεργοποίηση όσων υπήρχαν στη βάση αλλά έλειπαν από το τελευταίο Sync
        Entity::where('type', $type)
            ->whereNotIn('id', $processedIds)
            ->update(['active' => false]);
    }
}
