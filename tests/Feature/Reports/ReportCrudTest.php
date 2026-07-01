<?php

namespace Tests\Feature\Reports;

use App\Models\WeeklyReport;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReportCrudTest extends TestCase
{
    public function test_authenticated_user_can_list_reports(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        WeeklyReport::factory()
            ->count(3)
            ->create();

        $response = $this->getJson('/api/reports');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $response->assertJsonStructure([
            'success',
            'data',
            'meta' => [
                'current_page',
                'last_page',
                'per_page',
                'total',
            ],
        ]);
    }

    public function test_authenticated_user_can_update_a_report(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = $this->createDraftReport();

        $response = $this->putJson(
            "/api/reports/{$report->id}",
            [
                'department' => 'Finance',
                'week' => '2026-W27',
                'objectives' => 'Nouveaux objectifs',
                'activities' => 'Nouvelles activités',
                'achievements' => 'Nouvelles réalisations',
                'difficulties' => 'RAS',
                'next_actions' => 'Suite',
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('weekly_reports', [
            'id' => $report->id,
            'department' => 'Finance',
            'week' => '2026-W27',
        ]);
    }

    public function test_authenticated_user_can_create_a_report(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $employee = $this->createEmployee($user);

        $payload = [
            'employee_id' => $employee->id,
            'department' => 'IT',
            'week' => '2026-W26',
            'objectives' => 'Objectifs de la semaine',
            'activities' => 'Activités réalisées',
            'achievements' => 'Réalisations',
            'difficulties' => 'Aucune difficulté',
            'next_actions' => 'Actions prévues',
        ];

        $response = $this->postJson('/api/reports', $payload);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('weekly_reports', [
            'employee_id' => $employee->id,
            'week' => '2026-W26',
        ]);
    }

    public function test_authenticated_user_can_view_a_report(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = WeeklyReport::factory()->create();

        $response = $this->getJson("/api/reports/{$report->id}");

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_authenticated_user_can_delete_a_report(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $report = $this->createDraftReport();

        $response = $this->deleteJson(
            "/api/reports/{$report->id}"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseMissing(
            'weekly_reports',
            [
                'id' => $report->id,
            ]
        );
    }

    public function test_report_creation_requires_required_fields(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/reports', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'employee_id',
                'department',
                'week',
                'objectives',
                'activities',
                'achievements',
                'next_actions',
            ]);
    }

    public function test_guest_cannot_access_reports(): void
    {
        $response = $this->getJson('/api/reports');

        $response->assertUnauthorized();
    }

    public function test_user_cannot_view_unknown_report(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/reports/999999');

        $response->assertNotFound();
    }
}
