<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncRunLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sync_run_id',
        'source',
        'entity',
        'external_id',
        'action',
        'status',
        'message',
        'old_payload',
        'new_payload',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'old_payload' => 'array',
        'new_payload' => 'array',
        'meta' => 'array',
        'created_at' => 'datetime',
    ];
}
