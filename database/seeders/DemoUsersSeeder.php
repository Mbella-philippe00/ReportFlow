<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public const PASSWORD = 'password';

    /**
     * @return array<int, array{name: string, email: string}>
     */
    public static function managerUsers(): array
    {
        return [
            ['name' => 'Marc Operations', 'email' => 'marc.operations@reportflow.test'],
            ['name' => 'Nadia Finance', 'email' => 'nadia.finance@reportflow.test'],
            ['name' => 'Jean Quality', 'email' => 'jean.quality@reportflow.test'],
        ];
    }

    /**
     * @return array<int, array{name: string, first_name: string, last_name: string, email: string, department: string, active: bool}>
     */
    public static function employeeUsers(): array
    {
        return [
            ['name' => 'Alice Martin', 'first_name' => 'Alice', 'last_name' => 'Martin', 'email' => 'alice.martin@reportflow.test', 'department' => 'Engineering', 'active' => true],
            ['name' => 'Bruno Leclerc', 'first_name' => 'Bruno', 'last_name' => 'Leclerc', 'email' => 'bruno.leclerc@reportflow.test', 'department' => 'Operations', 'active' => true],
            ['name' => 'Camille Bernard', 'first_name' => 'Camille', 'last_name' => 'Bernard', 'email' => 'camille.bernard@reportflow.test', 'department' => 'Finance', 'active' => true],
            ['name' => 'David Moreau', 'first_name' => 'David', 'last_name' => 'Moreau', 'email' => 'david.moreau@reportflow.test', 'department' => 'Product', 'active' => true],
            ['name' => 'Elodie Garnier', 'first_name' => 'Elodie', 'last_name' => 'Garnier', 'email' => 'elodie.garnier@reportflow.test', 'department' => 'Quality', 'active' => false],
            ['name' => 'Farid Benali', 'first_name' => 'Farid', 'last_name' => 'Benali', 'email' => 'farid.benali@reportflow.test', 'department' => 'Support', 'active' => true],
            ['name' => 'Grace Mballa', 'first_name' => 'Grace', 'last_name' => 'Mballa', 'email' => 'grace.mballa@reportflow.test', 'department' => 'Human Resources', 'active' => true],
            ['name' => 'Hugo Petit', 'first_name' => 'Hugo', 'last_name' => 'Petit', 'email' => 'hugo.petit@reportflow.test', 'department' => 'Sales', 'active' => true],
            ['name' => 'Ines Robert', 'first_name' => 'Ines', 'last_name' => 'Robert', 'email' => 'ines.robert@reportflow.test', 'department' => 'Operations', 'active' => true],
            ['name' => 'Jules Simon', 'first_name' => 'Jules', 'last_name' => 'Simon', 'email' => 'jules.simon@reportflow.test', 'department' => 'Engineering', 'active' => true],
            ['name' => 'Lea Dubois', 'first_name' => 'Lea', 'last_name' => 'Dubois', 'email' => 'lea.dubois@reportflow.test', 'department' => 'Finance', 'active' => true],
        ];
    }

    public function run(): void
    {
        $this->createUser('super-admin', [
            'name' => 'Amina ReportFlow Admin',
            'email' => 'admin@reportflow.test',
        ]);

        foreach (self::managerUsers() as $manager) {
            $this->createUser('manager', $manager);
        }

        foreach (self::employeeUsers() as $employee) {
            $this->createUser('employee', [
                'name' => $employee['name'],
                'email' => $employee['email'],
            ]);
        }
    }

    /**
     * @param  array{name: string, email: string}  $attributes
     */
    private function createUser(string $role, array $attributes): User
    {
        $user = User::where('email', $attributes['email'])->first();

        if (! $user) {
            $factory = match ($role) {
                'super-admin' => User::factory()->superAdmin(),
                'manager' => User::factory()->manager(),
                default => User::factory()->employee(),
            };

            $user = $factory
                ->withPassword(self::PASSWORD)
                ->create($attributes);
        } else {
            $user->forceFill([
                'name' => $attributes['name'],
                'password' => Hash::make(self::PASSWORD),
                'email_verified_at' => now(),
            ])->save();
        }

        $user->syncRoles([$role]);

        return $user;
    }
}