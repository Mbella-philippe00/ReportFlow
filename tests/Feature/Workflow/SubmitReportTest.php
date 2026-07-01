<?php

namespace Tests\Feature\Workflow;

use App\Services\AI\WeeklyReportAiService;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class SubmitReportTest extends TestCase
{
    public function test_employee_can_submit_a_draft_report(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = $this->createDraftReport();

        $response = $this->postJson(
            "/api/reports/{$report->id}/submit"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas(
            'weekly_reports',
            [
                'id' => $report->id,
                'status' => 'submitted',
            ]
        );
        $this->assertEquals(
            'submitted',
            $report->fresh()->status->value
        );
        $this->assertTrue(
            Activity::where('subject_id', $report->id)
                ->where('description', 'Rapport soumis')
                ->exists()
        );

        $this->assertNotNull(
            $report->fresh()->submitted_at
        );
        $this->assertTrue(
            $report->fresh()->submitted_at->isToday()
        );
    }

    public function test_submit_generates_executive_summary_when_missing(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = $this->createDraftReport();

        $report->update([
            'executive_summary' => null,
        ]);
        $mock = Mockery::mock(WeeklyReportAiService::class);

        $mock->shouldReceive('generateExecutiveSummary')
            ->once()
            ->andReturn('Résumé généré automatiquement par le mock.');

        $this->app->instance(
            WeeklyReportAiService::class,
            $mock
        );

        $this->postJson("/api/reports/{$report->id}/submit")
            ->assertOk();

        $this->assertNotNull(
            $report->fresh()->executive_summary
        );
    }

    public function test_submit_does_not_override_existing_summary(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = $this->createDraftReport();

        $report->update([
            'executive_summary' => 'Résumé déjà présent',
        ]);

        $this->postJson("/api/reports/{$report->id}/submit")
            ->assertOk();

        $this->assertEquals(
            'Résumé déjà présent',
            $report->fresh()->executive_summary
        );
    }

    public function test_submitted_report_cannot_be_submitted_twice(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = $this->createSubmittedReport();

        $this->postJson("/api/reports/{$report->id}/submit")
            ->assertStatus(422);
    }
}
