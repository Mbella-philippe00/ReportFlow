<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    public const DEPARTMENTS = [
        'Engineering',
        'Finance',
        'Human Resources',
        'Operations',
        'Product',
        'Quality',
        'Sales',
        'Support',
    ];

    protected $model = Employee::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'user_id' => User::factory(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'department' => fake()->randomElement(self::DEPARTMENTS),
            'active' => true,
        ];
    }

    public function department(string $department): static
    {
        return $this->state(fn () => [
            'department' => $department,
        ]);
    }

    public function forUser(User $user): static
    {
        [$firstName, $lastName] = array_pad(explode(' ', $user->name, 2), 2, '');

        return $this->state(fn () => [
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName !== '' ? $lastName : $firstName,
            'email' => $user->email,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'active' => false,
        ]);
    }
}