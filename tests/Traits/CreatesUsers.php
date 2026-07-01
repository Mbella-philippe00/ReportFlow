<?php

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesUsers
{
    protected function createUser(
        array $attributes = []
    ): User {

        return User::factory()->create(
            array_merge([
                'password' => Hash::make('password123'),
            ], $attributes)
        );
    }

    protected function createManager(): User
    {
        $user = $this->createUser();

        $user->assignRole('manager');

        return $user;
    }

    protected function createSuperAdmin(): User
    {
        $user = $this->createUser();

        $user->assignRole('super-admin');

        return $user;
    }

    protected function createEmployeeUser(): User
    {
        $user = $this->createUser();

        $user->assignRole('employee');

        return $user;
    }
}
