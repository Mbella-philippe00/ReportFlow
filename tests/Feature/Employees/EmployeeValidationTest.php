<?php

namespace Tests\Feature\Employees;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EmployeeValidationTest extends TestCase
{
    public function test_employee_creation_requires_required_fields(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $this->postJson('/api/employees', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
                'first_name',
                'last_name',
            ]);
    }

    public function test_employee_email_must_be_unique(): void
    {
        $manager = $this->createManager();
        $existing = $this->createEmployee(null, [
            'email' => 'duplicate@example.com',
        ]);

        Sanctum::actingAs($manager);

        $this->postJson('/api/employees', [
            'email' => $existing->email,
            'first_name' => 'Duplicate',
            'last_name' => 'Employee',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_employee_user_id_must_be_unique_when_present(): void
    {
        $manager = $this->createManager();
        $existingUser = $this->createEmployeeUser();

        $this->createEmployee($existingUser);

        Sanctum::actingAs($manager);

        $this->postJson('/api/employees', [
            'email' => 'unique-user@example.com',
            'first_name' => 'Unique',
            'last_name' => 'User',
            'user_id' => $existingUser->id,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['user_id']);
    }

    public function test_employee_update_validates_unique_email(): void
    {
        $manager = $this->createManager();
        $existing = $this->createEmployee(null, [
            'email' => 'existing@example.com',
        ]);
        $employee = $this->createEmployee(null, [
            'email' => 'target@example.com',
        ]);

        Sanctum::actingAs($manager);

        $this->putJson("/api/employees/{$employee->id}", [
            'email' => $existing->email,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_employee_list_validates_filters_and_sorting(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $this->getJson('/api/employees?active=maybe&sort=unknown&direction=sideways&per_page=500')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'active',
                'direction',
                'per_page',
                'sort',
            ]);
    }
}