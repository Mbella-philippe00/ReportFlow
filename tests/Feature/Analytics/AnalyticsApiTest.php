<?php

namespace Tests\Feature\Analytics;

use App\Models\WeeklyReport;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnalyticsApiTest extends TestCase
{
    public function test_manager_can_access_all_analytics_endpoints(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee(null, [
            'department' => 'IT',
            'first_name' => 'Ada',
            'last_name' => 'Analyst',
        ]);
        $report = WeeklyReport::factory()
            ->for($employee)
            ->generated()
            ->create(['department' => 'IT']);

        activity()
            ->performedOn($report)
            ->causedBy($manager)
            ->withProperties(['week' => $report->week])
            ->log('Rapport valid? d?finitivement');

        Sanctum::actingAs($manager);

        $this->getJson('/api/analytics/overview')
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'total_reports',
                    'submitted_reports',
                    'approved_reports',
                    'rejected_reports',
                    'generated_reports',
                    'pending_reports',
                    'validation_rate',
                    'completion_rate',
                    'average_approval_time',
                    'status_distribution',
                ],
                'filters',
            ]);

        $this->getJson('/api/analytics/trends?granularity=weekly')
            ->assertOk()
            ->assertJsonPath('data.type', 'trends')
            ->assertJsonStructure(['success', 'data' => ['type', 'data', 'meta'], 'filters']);

        $this->getJson('/api/analytics/reports')
            ->assertOk()
            ->assertJsonPath('data.type', 'reports')
            ->assertJsonStructure(['success', 'data' => ['type', 'data', 'meta'], 'filters']);

        $this->getJson('/api/analytics/employees')
            ->assertOk()
            ->assertJsonPath('data.type', 'employees')
            ->assertJsonPath('data.data.0.employee.name', 'Ada Analyst');

        $this->getJson('/api/analytics/departments')
            ->assertOk()
            ->assertJsonPath('data.type', 'departments')
            ->assertJsonPath('data.data.0.department', 'IT');

        $this->getJson('/api/analytics/workflow')
            ->assertOk()
            ->assertJsonPath('data.type', 'workflow')
            ->assertJsonStructure(['success', 'data' => ['type', 'data', 'meta'], 'filters']);

        $this->getJson('/api/analytics/activity')
            ->assertOk()
            ->assertJsonPath('data.0.description', 'Rapport valid? d?finitivement')
            ->assertJsonStructure(['success', 'data', 'meta', 'filters']);

        $this->getJson('/api/analytics/export-options')
            ->assertOk()
            ->assertJsonPath('data.supported', true)
            ->assertJsonStructure(['success', 'data' => ['supported', 'available_formats', 'message', 'future_formats']]);
    }
}
