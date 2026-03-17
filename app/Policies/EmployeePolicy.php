<?php

namespace App\Policies;
use App\Models\Employee;


class EmployeePolicy
{
    public function delete(Employee $actingAdmin, Employee $targetAdmin): bool
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
