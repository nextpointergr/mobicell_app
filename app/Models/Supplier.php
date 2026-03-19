<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'source_url',
        'unique_node',
        'active',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('supplier')
            ->logOnly([
                'name',
                'source_url',
                'unique_node',
                'active',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function canBeDeleted(): bool
    {


        return true;
    }
}
