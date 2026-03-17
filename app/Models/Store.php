<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Store extends Model
{
    protected $table = 'stores';

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'active',
        'central',

        // PYLON
        'pylon_base_url',
        'pylon_apicode',
        'pylon_databasealias',
        'pylon_username',
        'pylon_password',
        'pylon_applicationname',
    ];

    protected $casts = [
        'active' => 'boolean',
        'central' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($store) {

            $store->slug = static::generateSlug($store->slug ?? $store->name);

            if ($store->central) {
                static::resetCentral();
            }
        });

        static::updating(function ($store) {

            if ($store->isDirty('name') || $store->isDirty('slug')) {
                $store->slug = static::generateSlug(
                    $store->slug ?: $store->name,
                    $store->id
                );
            }

            if ($store->isDirty('central') && $store->central) {
                static::resetCentral($store->id);
            }
        });
    }


    protected static function resetCentral(?int $ignoreId = null): void
    {
        static::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->update(['central' => false]);
    }

    /*
    |--------------------------------------------------------------------------
    | Slug Helpers
    |--------------------------------------------------------------------------
    */

    protected static function generateSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);

        $original = $slug;
        $counter = 1;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | Pylon Helpers
    |--------------------------------------------------------------------------
    */

    public function getPylonConfig(): array
    {
        return [
            'base_url' => $this->pylon_base_url,
            'apicode' => $this->pylon_apicode,
            'databasealias' => $this->pylon_databasealias,
            'username' => $this->pylon_username,
            'password' => $this->pylon_password, // decrypted
            'applicationname' => $this->pylon_applicationname,
        ];
    }

    public function hasPylon(): bool
    {
        return !empty($this->pylon_base_url)
            && !empty($this->pylon_apicode)
            && !empty($this->pylon_databasealias)
            && !empty($this->pylon_username)
            && !empty($this->pylon_password);
    }

    /*
    |--------------------------------------------------------------------------
    | Encryption (VERY IMPORTANT)
    |--------------------------------------------------------------------------
    */

    public function setPylonPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['pylon_password'] = Crypt::encryptString($value);
        }
    }

    public function getPylonPasswordAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // fallback αν δεν είναι encrypted
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function entityValues()
    {
        return $this->hasMany(EntityStoreValue::class, 'store_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeCentral($query)
    {
        return $query->where('central', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function getCentral(): ?self
    {
        return static::where('central', true)->first();
    }

    public function canBeDeleted(): bool
    {

        if ($this->central) {
            return false;
        }

        if ($this->entityValues()->exists()) {
            return false;
        }

        return true;
    }
}
