<?php
use Illuminate\Support\Facades\Cache;
use App\Services\Mappings\MappingGuard;
use Illuminate\Support\Str;
if (! function_exists('get_system_pagination')) {
    function get_system_pagination(): int
    {
        return \App\Models\Setting::get('admin_panel_list_pagination_number', 7);
    }
}


if (! function_exists('cacheVersion')) {
    function cacheVersion(string $key, int $default = 1)
    {
        return cache()->rememberForever(
            "cache.version.{$key}",
            fn () => $default
        );
    }
}

if (!function_exists('smtpConfigReady')) {
    function smtpConfigReady(): bool
    {
        return (bool)\App\Models\Setting::get('mail_is_valid', false);

    }
}

if (! function_exists('notification_email')) {
    function notification_email(): ?string
    {
        return \App\Models\Setting::get('email_notification');
    }
}


if (! function_exists('getApiKey')) {
    function getApiKey(): ?string
    {
        return \App\Models\Setting::get('system_api_key');
    }
}

function permission_label(string $permission): string
{
    $key = 'permissions.' . $permission;
    if (trans()->has($key)) {
        return __($key);
    }
    return Str::of($permission)
        ->after('admin.')
        ->replace('.', ' ')
        ->title();
}


function isSyncBlocked(): bool
{
    return MappingGuard::hasUnmappedActiveEntities();
}
