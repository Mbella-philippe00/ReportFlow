<?php

namespace Tests\Feature\Employees;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EmployeeAuthorizationTest extends TestCase
{
    public function test_employee_cannot_list_employees(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $this->getJson('/api/employees')->assertForbidden();
    }

    public function test_employee_can_view_own_employee_record(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);

        Sanctum::actingAs($user);

        $this->getJson("/api/employees/{$employee->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $employee->id);
    }

    public function test_employee_cannot_view_another_employee_record(): void
    {
        $user = $this->createEmployeeUser();
        $otherEmployee = $this->createEmployee();

        Sanctum::actingAs($user);

        $this->getJson("/api/employees/{$otherEmployee->id}")->assertForbidden();
    }

    public function test_employee_cannot_create_update_or_delete_employee(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee();

        Sanctum::actingAs($user);

        $this->postJson('/api/employees', [
            'email' => 'blocked@example.com',
            'first_name' => 'Blocked',
            'last_name' => 'Employee',
        ])->assertForbidden();

        $this->putJson("/api/employees/{$employee->id}", [
            'first_name' => 'Blocked',
        ])->assertForbidden();

        $this->deleteJson("/api/employees/{$employee->id}")->assertForbidden();
    }

    public function test_manager_cannot_delete_employee(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee();

        Sanctum::actingAs($manager);

        $this->deleteJson("/api/employees/{$employee->id}")->assertForbidden();
    }

    public function test_employee_can_view_own_reports_and_activity(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        activity()
            ->performedOn($report)
            ->causedBy($user)
            ->log('Rapport soumis');

        Sanctum::actingAs($user);

        $this->getJson("/api/employees/{$employee->id}/reports")
            ->assertOk()
            ->assertJsonPath('meta.total', 1);

        $this->getJson("/api/employees/{$employee->id}/activity")
            ->assertOk()
            ->assertJsonPath('meta.total', 1);
    }
}