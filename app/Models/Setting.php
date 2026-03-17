<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value'
    ];
    public $timestamps = true;

    public static function get($key, $default = null)
    {
        $value = static::where('key', $key)->value('value');
        if ($value === null) {
            return $default;
        }
        if (is_string($value) && self::isJson($value)) {
            return json_decode($value, true);
        }
        return $value;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value)
                    ? json_encode($value)
                    : $value,
            ]
        );
    }

    protected static function isJson(string $value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }



    public static function smtpConfigReady(): bool
    {
        $settings = static::all()->pluck('value', 'key');

        $requiredKeys = [
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ];

        return collect($requiredKeys)->every(function ($key) use ($settings) {
            return $settings->has($key) && !empty($settings[$key]);
        });
    }
}
