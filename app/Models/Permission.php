<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'label',
        'group',
        'source',
        'is_locked',
        'sort_order',
    ];

    protected $casts = [
        'is_locked'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSystem($query)
    {
        return $query->where('source', 'system');
    }

    public function scopeRoutes($query)
    {
        return $query->where('source', 'route');
    }

    public function scopeManual($query)
    {
        return $query->where('source', 'manual');
    }

    public function scopeUnlocked($query)
    {
        return $query->where('is_locked', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isSystem(): bool
    {
        return $this->source === 'system';
    }

    public function isRoute(): bool
    {
        return $this->source === 'route';
    }

    public function isManual(): bool
    {
        return $this->source === 'manual';
    }

    public function canBeSynced(): bool
    {
        return ! $this->is_locked;
    }

}
