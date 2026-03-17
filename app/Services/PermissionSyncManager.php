<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use App\Services\PermissionSources\ConfigPermissionSource;
use App\Services\PermissionSources\RoutePermissionSource;
use Spatie\Permission\PermissionRegistrar;

class PermissionSyncManager
{
    public function sync(): array
    {
        $sources = [
            app(ConfigPermissionSource::class)->get(),
            app(RoutePermissionSource::class)->get(),
        ];

        $permissions = collect($sources)
            ->flatten(1)
            ->keyBy(fn ($p) => $p['guard'].'|'.$p['name']); // 🔥 prevent duplicates

        $created = 0;
        $updated = 0;

        foreach ($permissions as $data) {

            $permission = Permission::where('name', $data['name'])
                ->where('guard_name', $data['guard'])
                ->first();

            if (! $permission) {
                Permission::create([
                    'name'       => $data['name'],
                    'guard_name' => $data['guard'],
                    'label'      => $data['label'],
                    'group'      => $data['group'],
                    'source'     => $data['source'],
                ]);
                $created++;
            } else {
                $permission->update([
                    'label'  => $data['label'] ?? $permission->label,
                    'group'  => $data['group'] ?? $permission->group,
                    'source' => $data['source'],
                ]);
                $updated++;
            }
        }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        return compact('created', 'updated');
    }
}
