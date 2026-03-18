<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalSync extends Model
{
    protected $fillable = [
        'source',
        'entity',
        'last_synced_at',
        'last_cursor',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
    ];
}
