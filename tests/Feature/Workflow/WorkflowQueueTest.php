<?php

namespace Tests\Feature\Workflow;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WorkflowQueueTest extends TestCase
{
    public function test_manager_queue_returns_submitted_reports_for_manager(): void
    {
        $manager = $this->createManager();
        $submitted = $this->createSubmittedReport();
        $underReview = $this->createApprovedReport();

        Sanctum::actingAs($manager);

        $response = $this->getJson('/api/reports/workflow/queue');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $submitted->id)
            ->assertJsonPath('data.0.status.value', 'submitted');

        $this->assertNotSame($underReview->id, $response->json('data.0.id'));
    }

    public function test_super_admin_queue_includes_under_review_reports(): void
    {
        $admin = $this->createSuperAdmin();
        $this->createSubmittedReport();
        $this->createApprovedReport();

        Sanctum::actingAs($admin);

        $this->getJson('/api/reports/workflow/queue')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }
}
