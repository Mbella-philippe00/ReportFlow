<?php

namespace Tests\Feature\Workflow;

use App\Notifications\FinalReportApprovedNotification;
use App\Services\Reports\ReportPresentationService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class FinalApproveReportTest extends TestCase
{
    public function test_super_admin_can_approve_an_under_review_report(): void
    {
        Notification::fake();
        Mail::fake();

        $admin = $this->createSuperAdmin();
        $employeeUser = $this->createEmployeeUser();
        $employee = $this->createEmployee($employeeUser);
        $report = $this->createApprovedReport($employee);

        $presentation = Mockery::mock(ReportPresentationService::class);
        $presentation->shouldReceive('generatePowerPoint')
            ->once()
            ->andReturn('reports/report-demo.pptx');

        $this->app->instance(ReportPresentationService::class, $presentation);

        Sanctum::actingAs($admin);

        $response = $this->postJson("/api/reports/{$report->id}/final-approve");

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status.value', 'approved')
            ->assertJsonPath('data.is_read_only', true)
            ->assertJsonPath('data.available_actions', []);

        $report->refresh();

        $this->assertSame('approved', $report->status->value);
        $this->assertNotNull($report->approved_at);
        $this->assertNotNull($report->generated_at);
        $this->assertEquals($admin->id, $report->approved_by);
        $this->assertSame('reports/report-demo.pptx', $report->pptx_file);

        Notification::assertSentTo($employeeUser, FinalReportApprovedNotification::class);
    }

    public function test_manager_cannot_finally_approve_report(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createApprovedReport()->id}/final-approve")
            ->assertForbidden();
    }

    public function test_draft_report_cannot_be_finally_approved(): void
    {
        Sanctum::actingAs($this->createSuperAdmin());

        $this->postJson("/api/reports/{$this->createDraftReport()->id}/final-approve")
            ->assertForbidden();
    }

    public function test_submitted_report_cannot_be_finally_approved(): void
    {
        Sanctum::actingAs($this->createSuperAdmin());

        $this->postJson("/api/reports/{$this->createSubmittedReport()->id}/final-approve")
            ->assertForbidden();
    }

    public function test_approved_report_cannot_be_finally_approved_twice(): void
    {
        Sanctum::actingAs($this->createSuperAdmin());

        $this->postJson("/api/reports/{$this->createGeneratedReport()->id}/final-approve")
            ->assertForbidden();
    }

    public function test_approved_reports_are_read_only(): void
    {
        $employeeUser = $this->createEmployeeUser();
        $employee = $this->createEmployee($employeeUser);
        $report = $this->createGeneratedReport($employee);

        Sanctum::actingAs($employeeUser);

        $this->putJson("/api/reports/{$report->id}", [
            'achievements' => 'Trying to edit an approved report.',
        ])->assertForbidden();
    }
}
