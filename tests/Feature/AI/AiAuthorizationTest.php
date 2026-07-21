<?php

namespace Tests\Feature\AI;

use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AiAuthorizationTest extends TestCase
{
    public function test_guest_cannot_access_ai_endpoints(): void
    {
        $report = $this->createDraftReport();

        $this->getJson('/api/ai/providers')->assertUnauthorized();
        $this->getJson('/api/ai/history')->assertUnauthorized();
        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")->assertUnauthorized();
    }

    public function test_employee_cannot_access_ai_dashboard(): void
    {
        Sanctum::actingAs($this->createEmployeeUser());

        $this->getJson('/api/ai/dashboard')->assertForbidden();
    }

    public function test_employee_cannot_use_ai_on_another_users_report(): void
    {
        $this->fakeGemini();

        $user = $this->createEmployeeUser();
        $otherEmployee = $this->createEmployee();
        $report = $this->createDraftReport($otherEmployee);

        Sanctum::actingAs($user);

        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")
            ->assertForbidden();
    }

    public function test_employee_cannot_request_workflow_recommendation(): void
    {
        $this->fakeGemini();

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($user);

        $this->postJson("/api/ai/reports/{$report->id}/workflow-recommendation")
            ->assertForbidden();
    }

    public function test_manager_history_all_scope_can_include_other_users_generations(): void
    {
        $this->fakeGemini('Historique IA.');

        $employeeUser = $this->createEmployeeUser();
        $employee = $this->createEmployee($employeeUser);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($employeeUser);
        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")->assertOk();

        Sanctum::actingAs($this->createManager());
        $this->getJson('/api/ai/history?scope=all')
            ->assertOk()
            ->assertJsonPath('meta.total', 1);
    }

    private function fakeGemini(string $text = 'R?ponse IA.'): void
    {
        config([
            'ai.provider' => 'gemini',
            'ai.providers.gemini.api_key' => 'test-key',
            'ai.providers.gemini.model' => 'gemini-test',
            'ai.providers.openai.api_key' => null,
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-test',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => $text,
                                ],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);
    }
}
