<?php
namespace App\Services;

use App\Models\Store;

class ErpConfigurationService
{
    public function check(): array
    {
        $stores = Store::where('active', true)->get();

        $invalidStores = $stores->filter(fn($store) => !$store->hasPylon());

        return [
            'hasIssues' => $invalidStores->isNotEmpty(),
            'validCount' => $stores->count() - $invalidStores->count(),
            'invalidCount' => $invalidStores->count(),

            'invalidStores' => $invalidStores->map(fn($store) => [
                'id' => $store->id,
                'name' => $store->name,
                'slug' => $store->slug,
            ])->values()->toArray(),
        ];
    }
}
