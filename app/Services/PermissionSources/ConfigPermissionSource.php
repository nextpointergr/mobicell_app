<?php

namespace App\Services\PermissionSources;

class ConfigPermissionSource
{
    public function get(): array
    {
        $permissions = [];

        $groups = config('system_permissions.groups');


        foreach ($groups as $groupKey => $group) {

            foreach ($group['permissions'] as $name => $label) {
                $permissions[] = [
                    'name'       => $name,
                    'guard'      => $group['guard'],
                    'label'      => $label,
                    'group'      => $groupKey,
                    'source'     => 'config',
                ];
            }
        }

        return $permissions;
    }
}
