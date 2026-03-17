<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\LogOptions;


class Role extends SpatieRole
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'guard_name',
        'is_system',
        'position',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'position' => 'integer',
    ];

    public function isSystem(): bool
    {
        return $this->is_system === true;
    }

    /**
     * Admins that have this role
     */
    public function admins()
    {
        return $this->morphedByMany(
            Employee::class,
            'model',
            'model_has_roles',
            'role_id',
            'model_id'
        );
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function canBeDeleted(): bool
    {
        if ($this->isSystem()) {
            return false;
        }
        if ($this->admins()->exists()) {
            return false;
        }
        return true;
    }
}
