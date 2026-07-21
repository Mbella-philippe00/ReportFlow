<?php

namespace Tests\Feature\Analytics;

use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExecutiveAnalyticsTest extends TestCase
{
    public function test_manager_can_access_executive_analytics_center(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee(null, [
            'department' => 'Strategy',
            'first_name' => 'Eve',
            'last_name' => 'Executive',
        ]);

        WeeklyReport::factory()
            ->for($employee)
            ->generated($manager, now()->subDay())
            ->create([
                'created_at' => now()->subDays(3),
                'department' => 'Strategy',
            ]);

        Sanctum::actingAs($manager);

        $this->getJson('/api/analytics/executive-dashboard?period=last_30_days')
            ->assertOk()
            ->assertJsonPath('data.type', 'executive_dashboard')
            ->assertJsonStructure([
                'success',
                'data' => [
                    'type',
                    'data' => [
                        'headline_metrics',
                        'trendlines',
                        'department_leaders',
                        'employee_leaders',
                        'workflow_health',
                        'smart_alerts',
                    ],
                    'meta',
                ],
                'filters',
            ]);

        $this->getJson('/api/analytics/kpi-center')
            ->assertOk()
            ->assertJsonPath('data.type', 'kpi_center')
            ->assertJsonStructure(['data' => ['data' => ['kpis', 'categories']]]);

        $this->getJson('/api/analytics/comparisons')
            ->assertOk()
            ->assertJsonPath('data.type', 'comparisons')
            ->assertJsonPath('data.data.departments.0.department', 'Strategy');

        $this->getJson('/api/analytics/executive-report')
            ->assertOk()
            ->assertJsonPath('data.type', 'executive_report')
            ->assertJsonStructure(['data' => ['data' => ['summary', 'recommendations']]]);
    }

    public function test_smart_alerts_detect_workflow_backlogs(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee(null, ['department' => 'Operations']);

        WeeklyReport::factory()
            ->for($employee)
            ->submitted(CarbonImmutable::now()->subHours(60))
            ->create([
                'created_at' => now()->subDays(5),
                'department' => 'Operations',
            ]);

        Sanctum::actingAs($manager);

        $this->getJson('/api/analytics/alerts')
            ->assertOk()
            ->assertJsonPath('data.type', 'smart_alerts')
            ->assertJsonPath('data.data.0.id', 'submitted_backlog')
            ->assertJsonPath('data.meta.total_alerts', 1);
    }

    public function test_executive_exports_support_csv_excel_and_pdf(): void
    {
        $manager = $this->createManager();
        $employee = $this->createEmployee(null, ['department' => 'Finance']);

        WeeklyReport::factory()
            ->for($employee)
            ->generated($manager, now()->subDay())
            ->create([
                'created_at' => now()->subDays(2),
                'department' => 'Finance',
            ]);

        Sanctum::actingAs($manager);

        $this->getJson('/api/analytics/export-options')
            ->assertOk()
            ->assertJsonPath('data.supported', true)
            ->assertJsonPath('data.available_formats.0', 'csv')
            ->assertJsonPath('data.datasets.0', 'executive');

        $csv = $this->get('/api/analytics/export?format=csv&dataset=kpis');
        $csv->assertOk();
        $csv->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('kpi,value,unit,target,status', $csv->streamedContent());

        $excel = $this->get('/api/analytics/export?format=xlsx&dataset=comparisons');
        $excel->assertOk();
        $excel->assertHeader('content-type', 'application/vnd.ms-excel');
        $this->assertStringContainsString('Workbook', $excel->streamedContent());

        $pdf = $this->get('/api/analytics/export?format=pdf&dataset=executive');
        $pdf->assertOk();
        $pdf->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $pdf->streamedContent());
    }
}
