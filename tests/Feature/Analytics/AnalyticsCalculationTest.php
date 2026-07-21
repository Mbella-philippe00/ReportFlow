<?php

namespace Tests\Feature\Analytics;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnalyticsCalculationTest extends TestCase
{
    public function test_overview_calculates_report_totals_rates_and_average_approval_time(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-07-09 12:00:00'));

        try {
            $manager = $this->createManager();
            $employee = $this->createEmployee(null, ['department' => 'IT']);
            $financeEmployee = $this->createEmployee(null, ['department' => 'Finance']);

            WeeklyReport::factory()
                ->for($employee)
                ->draft()
                ->create([
                    'created_at' => now()->subDay(),
                    'department' => 'IT',
                ]);

            WeeklyReport::factory()
                ->for($employee)
                ->submitted()
                ->create([
                    'created_at' => now()->subDay(),
                    'department' => 'IT',
                    'submitted_at' => now()->subHours(5),
                ]);

            WeeklyReport::factory()
                ->for($employee)
                ->managerApproved()
                ->create([
                    'created_at' => now()->subDay(),
                    'department' => 'IT',
                    'submitted_at' => now()->subHours(6),
                    'validated_at' => now()->subHours(3),
                ]);

            WeeklyReport::factory()
                ->for($employee)
                ->generated()
                ->create([
                    'created_at' => now()->subDay(),
                    'department' => 'IT',
                    'submitted_at' => now()->subHours(8),
                    'validated_at' => now()->subHours(3),
                    'generated_at' => now()->subHours(2),
                    'pptx_file' => 'reports/generated.pptx',
                ]);

            WeeklyReport::factory()
                ->for($financeEmployee)
                ->rejected()
                ->create([
                    'created_at' => now()->subDay(),
                    'department' => 'Finance',
                    'submitted_at' => now()->subHours(4),
                    'rejected_at' => now()->subHours(2),
                ]);

            Sanctum::actingAs($manager);

            $response = $this->getJson('/api/analytics/overview?period=last_30_days');

            $response
                ->assertOk()
                ->assertJsonPath('data.total_reports', 5)
                ->assertJsonPath('data.submitted_reports', 1)
                ->assertJsonPath('data.approved_reports', 2)
                ->assertJsonPath('data.generated_reports', 1)
                ->assertJsonPath('data.rejected_reports', 1)
                ->assertJsonPath('data.pending_reports', 2)
                ->assertJsonPath('data.validation_rate', 50)
                ->assertJsonPath('data.completion_rate', 80)
                ->assertJsonPath('data.average_approval_time.minutes', 220);
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_analytics_filters_by_department_employee_and_status(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee(null, ['department' => 'IT']);
        $otherEmployee = $this->createEmployee(null, ['department' => 'Finance']);
        $generatedReport = WeeklyReport::factory()
            ->for($employee)
            ->generated()
            ->create([
                'department' => 'IT',
                'created_at' => now()->subDay(),
            ]);

        WeeklyReport::factory()
            ->for($otherEmployee)
            ->generated()
            ->create([
                'department' => 'Finance',
                'created_at' => now()->subDay(),
            ]);

        WeeklyReport::factory()
            ->for($employee)
            ->create([
                'department' => 'IT',
                'status' => ReportStatus::DRAFT,
                'created_at' => now()->subDay(),
            ]);

        Sanctum::actingAs($manager);

        $this->getJson("/api/analytics/overview?department=IT&employee={$employee->id}&status=approved")
            ->assertOk()
            ->assertJsonPath('data.total_reports', 1)
            ->assertJsonPath('data.generated_reports', 1)
            ->assertJsonPath('filters.department', 'IT')
            ->assertJsonPath('filters.employee', (string) $employee->id)
            ->assertJsonPath('filters.status', 'approved');

        $this->getJson('/api/analytics/reports?department=IT&status=approved')
            ->assertOk()
            ->assertJsonPath('data.meta.total_reports', 1)
            ->assertJsonPath('data.data.generated_powerpoint_statistics.generated_reports', 1)
            ->assertJsonPath('data.data.status_distribution.3.count', 1);

        $this->assertSame(ReportStatus::APPROVED, $generatedReport->fresh()->status);
    }

    public function test_employee_and_department_analytics_are_aggregated_from_reports(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee(null, [
            'department' => 'Operations',
            'first_name' => 'Report',
            'last_name' => 'Owner',
        ]);

        WeeklyReport::factory()
            ->for($employee)
            ->submitted()
            ->count(2)
            ->create(['department' => 'Operations']);

        WeeklyReport::factory()
            ->for($employee)
            ->generated()
            ->create(['department' => 'Operations']);

        Sanctum::actingAs($manager);

        $this->getJson('/api/analytics/employees?department=Operations')
            ->assertOk()
            ->assertJsonPath('data.meta.total_employees', 1)
            ->assertJsonPath('data.data.0.employee.name', 'Report Owner')
            ->assertJsonPath('data.data.0.total_reports', 3)
            ->assertJsonPath('data.data.0.reports_submitted', 3)
            ->assertJsonPath('data.data.0.generated_reports', 1);

        $this->getJson('/api/analytics/departments?department=Operations')
            ->assertOk()
            ->assertJsonPath('data.meta.total_departments', 1)
            ->assertJsonPath('data.data.0.department', 'Operations')
            ->assertJsonPath('data.data.0.active_employees', 1)
            ->assertJsonPath('data.data.0.total_reports', 3);
    }
}
