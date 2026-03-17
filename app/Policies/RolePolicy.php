<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(Admin $admin, Role $role): bool
    {

        if ($role->is_system) {
            return false;
        }


        if ($admin->hasRole($role->name)) {
            return false;
        }

        return true;
    }
}
