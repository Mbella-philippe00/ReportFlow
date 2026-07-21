<?php

namespace Tests\Feature\Workflow;

use App\Notifications\ManagerApprovedReportNotification;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ApproveReportTest extends TestCase
{
    public function test_manager_can_move_submitted_report_under_review_with_comment(): void
    {
        Notification::fake();

        $manager = $this->createManager();
        $admin = $this->createSuperAdmin();
        $report = $this->createSubmittedReport();

        Sanctum::actingAs($manager);

        $response = $this->postJson("/api/reports/{$report->id}/approve", [
            'comment' => 'Metrics are complete and risks are clearly documented.',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status.value', 'under_review')
            ->assertJsonPath('data.manager_comment', 'Metrics are complete and risks are clearly documented.')
            ->assertJsonPath('data.available_actions', ['reject']);

        $report->refresh();

        $this->assertSame('under_review', $report->status->value);
        $this->assertNotNull($report->under_review_at);
        $this->assertEquals($manager->id, $report->validated_by);
        $this->assertSame('Metrics are complete and risks are clearly documented.', $report->manager_comment);
        $this->assertTrue(
            Activity::where('subject_id', $report->id)
                ->where('description', 'Report moved under review')
                ->exists()
        );

        Notification::assertSentTo($admin, ManagerApprovedReportNotification::class);
    }

    public function test_timeline_exposes_manager_comment(): void
    {
        $manager = $this->createManager();
        $report = $this->createSubmittedReport();

        Sanctum::actingAs($manager);

        $this->postJson("/api/reports/{$report->id}/approve", [
            'comment' => 'Ready for final approval.',
        ])->assertOk();

        $this->getJson("/api/reports/{$report->id}/timeline")
            ->assertOk()
            ->assertJsonPath('data.1.key', 'submitted')
            ->assertJsonPath('data.2.key', 'under_review')
            ->assertJsonPath('data.2.comment', 'Ready for final approval.');
    }

    public function test_draft_report_cannot_be_moved_under_review(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createDraftReport()->id}/approve")
            ->assertForbidden();
    }

    public function test_under_review_report_cannot_be_approved_by_manager_twice(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createApprovedReport()->id}/approve")
            ->assertForbidden();
    }

    public function test_approved_report_cannot_be_moved_under_review(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->postJson("/api/reports/{$this->createGeneratedReport()->id}/approve")
            ->assertForbidden();
    }
}
