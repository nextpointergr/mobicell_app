<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityStoreValue extends Model
{
    protected $fillable = [
        'entity_id',
        'store_id',
        'erp_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
