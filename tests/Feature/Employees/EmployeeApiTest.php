<?php

namespace Tests\Feature\Employees;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\WeeklyReport;
use Laravel\Sanctum\Sanctum;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    public function test_manager_can_list_employees_with_search_filters_sorting_and_pagination(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $alice = $this->createEmployee(null, [
            'active' => true,
            'department' => 'IT',
            'email' => 'alice@example.com',
            'first_name' => 'Alice',
            'last_name' => 'Zephyr',
        ]);

        $this->createEmployee(null, [
            'active' => false,
            'department' => 'Finance',
            'email' => 'bob@example.com',
            'first_name' => 'Bob',
            'last_name' => 'Yellow',
        ]);

        $response = $this->getJson('/api/employees?search=alice&department=IT&active=1&sort=name&direction=asc&per_page=10');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    [
                        'id' => $alice->id,
                        'full_name' => 'Alice Zephyr',
                        'department' => 'IT',
                        'active' => true,
                    ],
                ],
            ])
            ->assertJsonPath('meta.total', 1)
            ->assertJsonStructure([
                'success',
                'data' => [
                    [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'email',
                        'department',
                        'active',
                        'role',
                        'roles',
                        'reports_count',
                        'user',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                ],
            ]);
    }

    public function test_manager_can_view_employee_detail_with_statistics_and_recent_reports(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $employee = $this->createEmployee(null, [
            'department' => 'Operations',
            'first_name' => 'Chris',
            'last_name' => 'Flow',
        ]);

        $this->createDraftReport($employee);
        $this->createSubmittedReport($employee);
        $this->createGeneratedReport($employee);

        $response = $this->getJson("/api/employees/{$employee->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $employee->id,
                    'department' => 'Operations',
                    'full_name' => 'Chris Flow',
                ],
                'statistics' => [
                    'total_reports' => 3,
                    'draft_reports' => 1,
                    'submitted_reports' => 1,
                    'generated_reports' => 1,
                ],
            ])
            ->assertJsonCount(3, 'recent_reports');
    }

    public function test_manager_can_create_and_update_employee(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $user = $this->createEmployeeUser();

        $createResponse = $this->postJson('/api/employees', [
            'active' => true,
            'department' => 'Finance',
            'email' => 'new.employee@example.com',
            'first_name' => 'New',
            'last_name' => 'Employee',
            'user_id' => $user->id,
        ]);

        $createResponse
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'email' => 'new.employee@example.com',
                    'department' => 'Finance',
                    'active' => true,
                ],
            ]);

        $employeeId = $createResponse->json('data.id');

        $updateResponse = $this->putJson("/api/employees/{$employeeId}", [
            'active' => false,
            'department' => 'Legal',
            'first_name' => 'Updated',
        ]);

        $updateResponse
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'first_name' => 'Updated',
                    'department' => 'Legal',
                    'active' => false,
                ],
            ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employeeId,
            'department' => 'Legal',
            'active' => false,
        ]);
    }

    public function test_super_admin_can_delete_employee(): void
    {
        $superAdmin = $this->createSuperAdmin();

        Sanctum::actingAs($superAdmin);

        $employee = $this->createEmployee();

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }

    public function test_employee_reports_endpoint_returns_only_employee_reports(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $employee = $this->createEmployee();
        $otherEmployee = $this->createEmployee();

        $ownReport = $this->createSubmittedReport($employee);
        $this->createSubmittedReport($otherEmployee);

        $response = $this->getJson("/api/employees/{$employee->id}/reports");

        $response
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $ownReport->id);
    }

    public function test_employee_activity_endpoint_returns_report_workflow_activity(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $employee = $this->createEmployee();
        $otherEmployee = $this->createEmployee();
        $report = $this->createSubmittedReport($employee);
        $otherReport = $this->createSubmittedReport($otherEmployee);

        activity()
            ->performedOn($report)
            ->causedBy($manager)
            ->withProperties(['week' => $report->week])
            ->log('Rapport soumis');

        activity()
            ->performedOn($otherReport)
            ->causedBy($manager)
            ->withProperties(['week' => $otherReport->week])
            ->log('Other report activity');

        $response = $this->getJson("/api/employees/{$employee->id}/activity");

        $response
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.description', 'Rapport soumis')
            ->assertJsonPath('data.0.report_id', $report->id);
    }

    public function test_guest_cannot_access_employees(): void
    {
        $this->getJson('/api/employees')->assertUnauthorized();
    }
}