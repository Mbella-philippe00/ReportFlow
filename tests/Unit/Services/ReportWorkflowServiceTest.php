<?php

namespace Tests\Unit\Services;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use App\Services\AI\WeeklyReportAiService;
use App\Services\NotificationService;
use App\Services\Reports\ActivityLogService;
use App\Services\Reports\ReportWorkflowService;
use App\Services\Reports\WorkflowStateMachine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ReportWorkflowServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_changes_report_status(): void
    {
        $report = WeeklyReport::factory()
            ->draft()
            ->withoutSummary()
            ->create();

        $ai = Mockery::mock(WeeklyReportAiService::class);
        $ai->shouldReceive('generateExecutiveSummary')
            ->once()
            ->andReturn('AI summary');

        $notifications = Mockery::mock(NotificationService::class);
        $notifications->shouldReceive('notifyManagers')->once();

        $service = new ReportWorkflowService(
            $ai,
            $notifications,
            new WorkflowStateMachine(),
            new ActivityLogService(),
        );

        $this->be($this->createEmployeeUser());

        $service->submit($report);

        $report->refresh();

        $this->assertEquals(ReportStatus::SUBMITTED, $report->status);
        $this->assertNotNull($report->submitted_at);
        $this->assertSame('AI summary', $report->executive_summary);
    }
}
