<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SupplierProduct extends Model
{

    use LogsActivity;
    protected $fillable = [
        'supplier_id',
        'external_id',
        'ean',
        'mpn',
        'name',
        'description',
        'short_description',
        'features',
        'raw_data',
        'price',
        'stock',
        'match_status',
        'import_status',
        'sync_action',
        'notes',
        'lookup_key',
        'hash',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('supplier')
            ->logOnly([
                'supplier_id',
                'external_id',
                'ean',
                'mpn',
                'name',
                'description',
                'short_description',
                'features',
                'raw_data',
                'price',
                'stock',
                'match_status',
                'import_status',
                'sync_action',
                'notes',
                'lookup_key',
                'hash',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
