<?php

namespace Tests\Feature\Workflow;

use Laravel\Sanctum\Sanctum;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ApproveReportTest extends TestCase
{
    public function test_manager_can_approve_a_submitted_report(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createSubmittedReport();

        $response = $this->postJson(
            "/api/reports/{$report->id}/approve"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $report->refresh();

        $this->assertEquals(
            'manager_approved',
            $report->status->value
        );

        $this->assertNotNull(
            $report->validated_at
        );

        $this->assertEquals(
            $manager->id,
            $report->validated_by
        );

        $this->assertTrue(
            Activity::where('subject_id', $report->id)
                ->where(
                    'description',
                    'Rapport pré-validé par manager'
                )
                ->exists()
        );
    }

    public function test_draft_report_cannot_be_approved(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createDraftReport();

        $this->postJson(
            "/api/reports/{$report->id}/approve"
        )->assertStatus(422);
    }

    public function test_manager_approved_report_cannot_be_approved_twice(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createApprovedReport();

        $this->postJson(
            "/api/reports/{$report->id}/approve"
        )->assertStatus(422);
    }

    public function test_generated_report_cannot_be_approved(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createGeneratedReport();

        $this->postJson(
            "/api/reports/{$report->id}/approve"
        )->assertStatus(422);
    }

    public function test_rejected_report_cannot_be_approved(): void
    {
        $manager = $this->createManager();

        Sanctum::actingAs($manager);

        $report = $this->createRejectedReport();

        $this->postJson(
            "/api/reports/{$report->id}/approve"
        )->assertStatus(422);
    }
}
