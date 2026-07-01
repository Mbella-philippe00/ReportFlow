<?php

namespace Tests\Feature\Workflow;

use App\Services\NotificationService;
use App\Services\Reports\ActivityLogService;
use App\Services\Reports\ReportPresentationService;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class FinalApproveReportTest extends TestCase
{
    public function test_super_admin_can_finally_approve_a_report(): void
    {
        $admin = $this->createSuperAdmin();

        Sanctum::actingAs($admin);

        $report = $this->createApprovedReport();

        /*
        |--------------------------------------------------------------------------
        | Mock PPT Generator
        |--------------------------------------------------------------------------
        */

        $presentation = Mockery::mock(
            ReportPresentationService::class
        );

        $presentation
            ->shouldReceive('generatePowerPoint')
            ->once()
            ->andReturn('reports/report-demo.pptx');

        $this->app->instance(
            ReportPresentationService::class,
            $presentation
        );

        /*
        |--------------------------------------------------------------------------
        | Mock Notifications
        |--------------------------------------------------------------------------
        */

        $notifications = Mockery::mock(
            NotificationService::class
        );

        $notifications
            ->shouldReceive('notifyEmployee')
            ->once();

        $this->app->instance(
            NotificationService::class,
            $notifications
        );

        /*
        |--------------------------------------------------------------------------
        | Mock Activity Logger
        |--------------------------------------------------------------------------
        */

        $logs = Mockery::mock(
            ActivityLogService::class
        );

        $logs
            ->shouldReceive('log')
            ->once();

        $this->app->instance(
            ActivityLogService::class,
            $logs
        );

        $response = $this->postJson(
            "/api/reports/{$report->id}/final-approve"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $report->refresh();

        $this->assertEquals(
            'generated',
            $report->status->value
        );

        $this->assertNotNull(
            $report->generated_at
        );

        $this->assertEquals(
            $admin->id,
            $report->validated_by
        );

        $this->assertEquals(
            'reports/report-demo.pptx',
            $report->pptx_file
        );
    }

    public function test_draft_report_cannot_be_finally_approved(): void
    {
        $admin = $this->createSuperAdmin();

        Sanctum::actingAs($admin);

        $report = $this->createDraftReport();

        $this->postJson(
            "/api/reports/{$report->id}/final-approve"
        )->assertStatus(422);
    }

    public function test_submitted_report_cannot_be_finally_approved(): void
    {
        $admin = $this->createSuperAdmin();

        Sanctum::actingAs($admin);

        $report = $this->createSubmittedReport();

        $this->postJson(
            "/api/reports/{$report->id}/final-approve"
        )->assertStatus(422);
    }

    public function test_generated_report_cannot_be_finally_approved_twice(): void
    {
        $admin = $this->createSuperAdmin();

        Sanctum::actingAs($admin);

        $report = $this->createGeneratedReport();

        $this->postJson(
            "/api/reports/{$report->id}/final-approve"
        )->assertStatus(422);
    }

    public function test_rejected_report_cannot_be_finally_approved(): void
    {
        $admin = $this->createSuperAdmin();

        Sanctum::actingAs($admin);

        $report = $this->createRejectedReport();

        $this->postJson(
            "/api/reports/{$report->id}/final-approve"
        )->assertStatus(422);
    }
}
