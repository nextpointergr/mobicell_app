<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Entity extends Model
{

    use LogsActivity;

    protected $fillable = [
        'type',
        'erp_id',
        'name',
        'active',
        'lookup_key',
        'hash'
    ];


    public function storeValues()
    {
        return $this->hasMany(EntityStoreValue::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('erp_sync')
            ->logOnly([
                'name',
                'active',
                'lookup_key'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
