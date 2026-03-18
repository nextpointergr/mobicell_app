<?php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Store;

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

if (! function_exists('store_slug')) {
    function store_slug(int $id): ?string
    {
        return Store::where('id', $id)->value('slug');
    }
}

if (! function_exists('central_store_slug')) {
    function central_store_slug(): ?string
    {
        $id = \App\Models\Setting::get('central_store_id');
        return $id ? store_slug($id) : null;
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
