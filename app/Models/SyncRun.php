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
        'errors',
        'total',
        'started_at',
        'finished_at',
        'meta',
        'user_id',
        'total_records'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'meta' => 'array',
    ];

}
