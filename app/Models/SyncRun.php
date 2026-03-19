<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncRun extends Model
{
    protected $fillable = [
        'source',
        'entity',
        'direction',
        'status',
        'processed',
        'created',
        'updated',
        'skipped',
        'deleted',
        'restored',
        'errors',
        'total',
        'total_records',
        'started_at',
        'finished_at',
        'meta',
        'error_message',
        'user_id',
    ];

    protected $casts = [
        'meta' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

}
