<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopData extends Model
{
    use SoftDeletes;

    protected $table = 'shop_data';

    protected $fillable = [
        'source',
        'type',
        'external_id',
        'hash',
        'payload',
        'last_synced_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'last_synced_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static function hasChanged(string $source, string $type, string $id, string $newHash): bool
    {
        $existingHash = self::where('source', $source)
            ->where('type', $type)
            ->where('external_id', $id)
            ->value('hash');

        return $existingHash !== $newHash;
    }
}
