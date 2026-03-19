<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductConflict extends Model
{
    protected $fillable = [
        'source',
        'source_entity_id',
        'external_id',
        'title',
        'conflict_type',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array' // Αυτόματη μετατροπή του JSON σε Array
    ];
}
