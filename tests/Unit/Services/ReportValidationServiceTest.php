<?php

namespace Tests\Unit\Services;

use App\Enums\ReportStatus;
use App\Services\NotificationService;
use App\Services\Reports\ActivityLogService;
use App\Services\Reports\ReportMailService;
use App\Services\Reports\ReportPresentationService;
use App\Services\Reports\ReportValidationService;
use App\Services\Reports\WorkflowStateMachine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class ReportValidationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_approve_changes_status(): void
    {
        $manager = $this->createManager();
        $this->be($manager);
        $report = $this->createSubmittedReport();

        $notifications = Mockery::mock(NotificationService::class);
        $notifications->shouldReceive('notifySuperAdmins')->once();

        $logs = Mockery::mock(ActivityLogService::class);
        $logs->shouldReceive('log')->once();

        $service = new ReportValidationService(
            $notifications,
            Mockery::mock(ReportPresentationService::class),
            Mockery::mock(ReportMailService::class),
            $logs,
            new WorkflowStateMachine(),
        );

        $service->managerApprove($report, 'Ready for final approval.');

        $report->refresh();

        $this->assertEquals(ReportStatus::UNDER_REVIEW, $report->status);
        $this->assertEquals($manager->id, $report->validated_by);
        $this->assertNotNull($report->under_review_at);
        $this->assertSame('Ready for final approval.', $report->manager_comment);
    }

    public function test_draft_report_cannot_be_manager_approved(): void
    {
        $this->be($this->createManager());

        $service = new ReportValidationService(
            Mockery::mock(NotificationService::class),
            Mockery::mock(ReportPresentationService::class),
            Mockery::mock(ReportMailService::class),
            Mockery::mock(ActivityLogService::class),
            new WorkflowStateMachine(),
        );

        $this->expectException(ValidationException::class);

        $service->managerApprove($this->createDraftReport());
    }

    public function test_final_approve_generates_presentation(): void
    {
        Mail::fake();

        $admin = $this->createSuperAdmin();
        $this->be($admin);
        $report = $this->createApprovedReport();

        $notifications = Mockery::mock(NotificationService::class);
        $notifications->shouldReceive('notifyEmployee')->once();

        $presentation = Mockery::mock(ReportPresentationService::class);
        $presentation->shouldReceive('generatePowerPoint')
            ->once()
            ->andReturn('reports/test.pptx');

        $logs = Mockery::mock(ActivityLogService::class);
        $logs->shouldReceive('log')->once();

        $service = new ReportValidationService(
            $notifications,
            $presentation,
            new ReportMailService(),
            $logs,
            new WorkflowStateMachine(),
        );

        $service->finalApprove($report);

        $report->refresh();

        $this->assertEquals(ReportStatus::APPROVED, $report->status);
        $this->assertSame('reports/test.pptx', $report->pptx_file);
        $this->assertNotNull($report->approved_at);
        $this->assertNotNull($report->generated_at);
        $this->assertEquals($admin->id, $report->approved_by);
    }

    public function test_reject_changes_status(): void
    {
        Mail::fake();

        $manager = $this->createManager();
        $this->be($manager);
        $report = $this->createSubmittedReport();

        $notifications = Mockery::mock(NotificationService::class);
        $notifications->shouldReceive('notifyEmployeeRejected')->once();

        $mail = Mockery::mock(ReportMailService::class);
        $mail->shouldReceive('sendRejectionMail')->once();

        $logs = Mockery::mock(ActivityLogService::class);
        $logs->shouldReceive('log')->once();

        $service = new ReportValidationService(
            $notifications,
            Mockery::mock(ReportPresentationService::class),
            $mail,
            $logs,
            new WorkflowStateMachine(),
        );

        $service->reject($report, 'Missing information');

        $report->refresh();

        $this->assertEquals(ReportStatus::REJECTED, $report->status);
        $this->assertSame('Missing information', $report->rejection_reason);
        $this->assertNotNull($report->rejected_at);
    }
}
