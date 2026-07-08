<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin']);
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin'])
            || $employee->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin']);
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin']);
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->hasRole('super-admin');
    }

    public function viewReports(User $user, Employee $employee): bool
    {
        return $this->view($user, $employee);
    }

    public function viewActivity(User $user, Employee $employee): bool
    {
        return $this->view($user, $employee);
    }
}