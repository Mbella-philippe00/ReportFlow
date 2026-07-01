<?php

namespace Tests\Traits;

use App\Models\Employee;
use App\Models\User;

trait CreatesEmployees
{
    protected function createEmployee(
        ?User $user = null,
        array $attributes = []
    ): Employee {

        $user ??= $this->createEmployeeUser();

        return Employee::factory()
            ->for($user)
            ->create(
                array_merge([
                    'department' => 'IT',
                ], $attributes)
            );
    }
}
