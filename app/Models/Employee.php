<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable, HasRoles , SoftDeletes, LogsActivity;
    protected $guarded = [];
    protected string $guard_name = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_system',
        'last_login_at',
        'last_login_ip',
        'last_login_agent',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_system' => 'boolean',
        'last_login_at'    => 'datetime',
    ];
    public function isSystem(): bool
    {
        return $this->is_system === true;
    }
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',

            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Employee Log');
    }


    public function canBeDeleted(): bool
    {
        return ! $this->isSystem();
    }


}
