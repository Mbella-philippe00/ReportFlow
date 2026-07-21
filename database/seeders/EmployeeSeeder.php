<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (DemoUsersSeeder::employeeUsers() as $profile) {
            $user = User::where('email', $profile['email'])->firstOrFail();
            $employee = Employee::where('email', $profile['email'])->first();

            $attributes = [
                'user_id' => $user->id,
                'first_name' => $profile['first_name'],
                'last_name' => $profile['last_name'],
                'email' => $profile['email'],
                'department' => $profile['department'],
                'active' => $profile['active'],
            ];

            if ($employee) {
                $employee->update($attributes);

                continue;
            }

            Employee::factory()
                ->forUser($user)
                ->department($profile['department'])
                ->create($attributes);
        }
    }
}