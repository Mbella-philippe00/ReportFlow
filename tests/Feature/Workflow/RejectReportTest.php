<?php

namespace Tests\Feature\Workflow;

use App\Services\Reports\ActivityLogService;
use App\Services\Reports\ReportMailService;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class RejectReportTest extends TestCase
{
    public function test_manager_can_reject_a_submitted_report(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createSubmittedReport();

        $mail = Mockery::mock(ReportMailService::class);

        $mail->shouldReceive('sendRejectionMail')
            ->once();

        $this->app->instance(
            ReportMailService::class,
            $mail
        );

        $logs = Mockery::mock(ActivityLogService::class);

        $logs->shouldReceive('log')
            ->once();

        $this->app->instance(
            ActivityLogService::class,
            $logs
        );

        $response = $this->postJson(
            "/api/reports/{$report->id}/reject",
            [
                'reason' => 'Informations incomplètes',
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $report->refresh();

        $this->assertEquals(
            'rejected',
            $report->status->value
        );

        $this->assertNotNull(
            $report->rejected_at
        );

        $this->assertEquals(
            $manager->id,
            $report->rejected_by
        );

        $this->assertEquals(
            'Informations incomplètes',
            $report->rejection_reason
        );
    }

    public function test_draft_report_cannot_be_rejected(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createDraftReport();

        $this->postJson(
            "/api/reports/{$report->id}/reject",
            [
                'reason' => 'Test',
            ]
        )->assertStatus(422);
    }

    public function test_generated_report_cannot_be_rejected(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createGeneratedReport();

        $this->postJson(
            "/api/reports/{$report->id}/reject",
            [
                'reason' => 'Test',
            ]
        )->assertStatus(422);
    }

    public function test_rejected_report_cannot_be_rejected_twice(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createRejectedReport();

        $this->postJson(
            "/api/reports/{$report->id}/reject",
            [
                'reason' => 'Test',
            ]
        )->assertStatus(422);
    }
}
