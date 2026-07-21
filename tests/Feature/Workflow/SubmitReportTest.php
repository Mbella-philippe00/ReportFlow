<?php

namespace Tests\Feature\Workflow;

use App\Notifications\WeeklyReportSubmittedNotification;
use App\Services\AI\WeeklyReportAiService;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class SubmitReportTest extends TestCase
{
    public function test_employee_can_submit_a_draft_report(): void
    {
        Notification::fake();

        $manager = $this->createManager();
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/reports/{$report->id}/submit");

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status.value', 'submitted')
            ->assertJsonPath('data.available_actions', []);

        $report->refresh();

        $this->assertSame('submitted', $report->status->value);
        $this->assertNotNull($report->submitted_at);
        $this->assertTrue($report->submitted_at->isToday());
        $this->assertTrue(
            Activity::where('subject_id', $report->id)
                ->where('description', 'Report submitted')
                ->exists()
        );

        Notification::assertSentTo($manager, WeeklyReportSubmittedNotification::class);
    }

    public function test_submit_generates_executive_summary_when_missing(): void
    {
        Notification::fake();

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        $report->update(['executive_summary' => null]);

        $mock = Mockery::mock(WeeklyReportAiService::class);
        $mock->shouldReceive('generateExecutiveSummary')
            ->once()
            ->andReturn('AI-generated executive summary.');

        $this->app->instance(WeeklyReportAiService::class, $mock);

        Sanctum::actingAs($user);

        $this->postJson("/api/reports/{$report->id}/submit")
            ->assertOk();

        $this->assertSame('AI-generated executive summary.', $report->fresh()->executive_summary);
    }

    public function test_submit_does_not_override_existing_summary(): void
    {
        Notification::fake();

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        $report->update(['executive_summary' => 'Existing summary']);

        Sanctum::actingAs($user);

        $this->postJson("/api/reports/{$report->id}/submit")
            ->assertOk();

        $this->assertSame('Existing summary', $report->fresh()->executive_summary);
    }

    public function test_submitted_report_cannot_be_submitted_twice(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($user);

        $this->postJson("/api/reports/{$report->id}/submit")
            ->assertForbidden();
    }
}
