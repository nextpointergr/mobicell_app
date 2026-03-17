<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    public function delete(Admin $actingAdmin, Admin $targetAdmin): bool
    {

        if ($targetAdmin->is_system) {
            return false;
        }


        if ($actingAdmin->id === $targetAdmin->id) {
            return false;
        }

        return true;
    }



}
