<?php

namespace Tests\Feature\Workflow;

use App\Notifications\WeeklyReportRejectedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RejectReportTest extends TestCase
{
    public function test_manager_can_reject_a_submitted_report(): void
    {
        Notification::fake();
        Mail::fake();

        $manager = $this->createManager();
        $employeeUser = $this->createEmployeeUser();
        $employee = $this->createEmployee($employeeUser);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($manager);

        $response = $this->postJson("/api/reports/{$report->id}/reject", [
            'reason' => 'Missing measurable outcomes.',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status.value', 'rejected')
            ->assertJsonPath('data.rejection_reason', 'Missing measurable outcomes.');

        $report->refresh();

        $this->assertSame('rejected', $report->status->value);
        $this->assertNotNull($report->rejected_at);
        $this->assertEquals($manager->id, $report->rejected_by);
        $this->assertSame('Missing measurable outcomes.', $report->rejection_reason);

        Notification::assertSentTo($employeeUser, WeeklyReportRejectedNotification::class);
    }

    public function test_super_admin_can_reject_an_under_review_report(): void
    {
        Notification::fake();
        Mail::fake();

        $admin = $this->createSuperAdmin();
        $report = $this->createApprovedReport();

        Sanctum::actingAs($admin);

        $this->postJson("/api/reports/{$report->id}/reject", [
            'reason' => 'Final review found missing context.',
        ])
            ->assertOk()
            ->assertJsonPath('data.status.value', 'rejected');
    }

    public function test_draft_report_cannot_be_rejected(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createDraftReport()->id}/reject", [
            'reason' => 'Test',
        ])->assertForbidden();
    }

    public function test_approved_report_cannot_be_rejected(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createGeneratedReport()->id}/reject", [
            'reason' => 'Test',
        ])->assertForbidden();
    }

    public function test_rejected_report_cannot_be_rejected_twice(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createRejectedReport()->id}/reject", [
            'reason' => 'Test',
        ])->assertForbidden();
    }
}
