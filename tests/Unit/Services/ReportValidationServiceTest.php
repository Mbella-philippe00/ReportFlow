<?php

namespace Tests\Unit\Services;

use App\Enums\ReportStatus;
use App\Services\NotificationService;
use App\Services\Reports\ActivityLogService;
use App\Services\Reports\ReportMailService;
use App\Services\Reports\ReportPresentationService;
use App\Services\Reports\ReportValidationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $presentation = Mockery::mock(ReportPresentationService::class);

        $mail = Mockery::mock(ReportMailService::class);
        $mail->shouldReceive('sendValidationMail')->once();

        $logs = Mockery::mock(ActivityLogService::class);
        $logs->shouldReceive('log')->once();

        $service = new ReportValidationService(
            $notifications,
            $presentation,
            $mail,
            $logs
        );

        $service->managerApprove($report);

        $report->refresh();

        $this->assertEquals(
            ReportStatus::MANAGER_APPROVED,
            $report->status
        );

        $this->assertEquals(
            $manager->id,
            $report->validated_by
        );

        $this->assertNotNull(
            $report->validated_at
        );
    }

    public function test_draft_report_cannot_be_manager_approved(): void
    {
        $manager = $this->createManager();

        $this->be($manager);

        $report = $this->createDraftReport();

        $service = new ReportValidationService(
            Mockery::mock(NotificationService::class),
            Mockery::mock(ReportPresentationService::class),
            Mockery::mock(ReportMailService::class),
            Mockery::mock(ActivityLogService::class),
        );

        $this->expectException(
            ValidationException::class
        );

        $service->managerApprove($report);
    }

    public function test_final_approve_generates_presentation(): void
    {
        $admin = $this->createSuperAdmin();

        $this->be($admin);

        $report = $this->createApprovedReport();

        $notifications = Mockery::mock(NotificationService::class);
        $notifications->shouldReceive('notifyEmployee')->once();

        $presentation = Mockery::mock(ReportPresentationService::class);

        $presentation
            ->shouldReceive('generatePowerPoint')
            ->once()
            ->andReturn('reports/test.pptx');

        $mail = Mockery::mock(ReportMailService::class);

        $logs = Mockery::mock(ActivityLogService::class);
        $logs->shouldReceive('log')->once();

        $service = new ReportValidationService(
            $notifications,
            $presentation,
            $mail,
            $logs
        );

        $service->finalApprove($report);

        $report->refresh();

        $this->assertEquals(
            ReportStatus::GENERATED,
            $report->status
        );

        $this->assertEquals(
            'reports/test.pptx',
            $report->pptx_file
        );

        $this->assertNotNull(
            $report->generated_at
        );
    }

    public function test_reject_changes_status(): void
    {
        $manager = $this->createManager();

        $this->be($manager);

        $report = $this->createSubmittedReport();

        $notifications = Mockery::mock(NotificationService::class);

        $presentation = Mockery::mock(ReportPresentationService::class);

        $mail = Mockery::mock(ReportMailService::class);
        $mail->shouldReceive('sendRejectionMail')->once();

        $logs = Mockery::mock(ActivityLogService::class);
        $logs->shouldReceive('log')->once();

        $service = new ReportValidationService(
            $notifications,
            $presentation,
            $mail,
            $logs
        );

        $service->reject(
            $report,
            'Informations manquantes'
        );

        $report->refresh();

        $this->assertEquals(
            ReportStatus::REJECTED,
            $report->status
        );

        $this->assertEquals(
            'Informations manquantes',
            $report->rejection_reason
        );

        $this->assertNotNull(
            $report->rejected_at
        );
    }
}
