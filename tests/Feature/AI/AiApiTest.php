<?php

namespace Tests\Feature\AI;

use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AiApiTest extends TestCase
{
    public function test_employee_can_generate_and_persist_executive_summary_for_own_report(): void
    {
        $this->fakeGemini('Resume executif genere.');

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/ai/reports/{$report->id}/executive-summary", [
            'persist' => true,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.action', 'executive_summary')
            ->assertJsonPath('data.content', 'Resume executif genere.')
            ->assertJsonPath('data.provider', 'gemini')
            ->assertJsonPath('data.model', 'gemini-test')
            ->assertJsonPath('data.metadata.persisted', true)
            ->assertJsonPath('data.report.executive_summary', 'Resume executif genere.');

        $this->assertDatabaseHas('weekly_reports', [
            'id' => $report->id,
            'executive_summary' => 'Resume executif genere.',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'ai',
            'description' => 'AI generation completed',
            'subject_id' => $report->id,
        ]);
    }

    public function test_manager_can_use_report_assistant_and_view_history_dashboard_and_providers(): void
    {
        $this->fakeGemini('Analyse IA generee.');

        $manager = $this->createManager();
        $report = $this->createSubmittedReport();

        Sanctum::actingAs($manager);

        $this->postJson("/api/ai/reports/{$report->id}/assist", [
            'action' => 'risk_analysis',
            'section' => 'difficulties',
            'text' => 'Retard fournisseur critique.',
        ])
            ->assertOk()
            ->assertJsonPath('data.action', 'risk_analysis')
            ->assertJsonPath('data.content', 'Analyse IA generee.')
            ->assertJsonPath('data.provider', 'gemini');

        $this->getJson('/api/ai/history')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.action', 'risk_analysis');

        $this->getJson('/api/ai/dashboard')
            ->assertOk()
            ->assertJsonPath('data.total_generations', 1)
            ->assertJsonPath('data.today_generations', 1);

        $this->getJson('/api/ai/providers')
            ->assertOk()
            ->assertJsonPath('data.1.name', 'gemini')
            ->assertJsonPath('data.1.configured', true)
            ->assertJsonPath('data.1.active', true);
    }

    public function test_manager_can_generate_workflow_recommendation(): void
    {
        $this->fakeGemini('Recommandation: demander des precisions.');

        $manager = $this->createManager();
        $report = $this->createSubmittedReport();

        Sanctum::actingAs($manager);

        $this->postJson("/api/ai/reports/{$report->id}/workflow-recommendation")
            ->assertOk()
            ->assertJsonPath('data.action', 'workflow_recommendation')
            ->assertJsonPath('data.content', 'Recommandation: demander des precisions.')
            ->assertJsonPath('data.provider', 'gemini');
    }

    public function test_employee_can_generate_with_openai_provider(): void
    {
        $this->fakeOpenAi('Resume OpenAI.');

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($user);

        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")
            ->assertOk()
            ->assertJsonPath('data.content', 'Resume OpenAI.')
            ->assertJsonPath('data.provider', 'openai')
            ->assertJsonPath('data.model', 'openai-test');
    }

    public function test_gemini_quota_exhaustion_falls_back_to_openai(): void
    {
        config([
            'ai.provider' => 'gemini',
            'ai.providers.gemini.api_key' => 'gemini-key',
            'ai.providers.gemini.model' => 'gemini-test',
            'ai.providers.openai.api_key' => 'openai-key',
            'ai.providers.openai.model' => 'openai-test',
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'error' => [
                    'code' => 429,
                    'status' => 'RESOURCE_EXHAUSTED',
                    'message' => 'Quota exceeded.',
                ],
            ], 429),
            'api.openai.com/*' => Http::response([
                'output' => [
                    [
                        'content' => [
                            [
                                'text' => 'Fallback OpenAI.',
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($user);

        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")
            ->assertOk()
            ->assertJsonPath('data.content', 'Fallback OpenAI.')
            ->assertJsonPath('data.provider', 'openai')
            ->assertJsonPath('data.model', 'openai-test');
    }

    public function test_openai_failure_falls_back_to_gemini(): void
    {
        config([
            'ai.provider' => 'openai',
            'ai.providers.openai.api_key' => 'openai-key',
            'ai.providers.openai.model' => 'openai-test',
            'ai.providers.gemini.api_key' => 'gemini-key',
            'ai.providers.gemini.model' => 'gemini-test',
        ]);

        Http::fake([
            'api.openai.com/*' => Http::response([
                'error' => [
                    'message' => 'Invalid API key.',
                ],
            ], 401),
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => 'Fallback Gemini.',
                                ],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($user);

        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")
            ->assertOk()
            ->assertJsonPath('data.content', 'Fallback Gemini.')
            ->assertJsonPath('data.provider', 'gemini')
            ->assertJsonPath('data.model', 'gemini-test');
    }

    public function test_missing_openai_key_returns_meaningful_error(): void
    {
        config([
            'ai.provider' => 'openai',
            'ai.providers.openai.api_key' => null,
            'ai.providers.openai.model' => 'openai-test',
            'ai.providers.gemini.api_key' => null,
            'ai.providers.gemini.model' => 'gemini-test',
        ]);

        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createDraftReport($employee);

        Sanctum::actingAs($user);

        $this->postJson("/api/ai/reports/{$report->id}/executive-summary")
            ->assertStatus(503)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'OpenAI API key missing.');
    }

    private function fakeGemini(string $text): void
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

    private function fakeOpenAi(string $text): void
    {
        config([
            'ai.provider' => 'openai',
            'ai.providers.openai.api_key' => 'test-key',
            'ai.providers.openai.model' => 'openai-test',
            'ai.providers.gemini.api_key' => null,
        ]);

        Http::fake([
            'api.openai.com/*' => Http::response([
                'output' => [
                    [
                        'content' => [
                            [
                                'text' => $text,
                            ],
                        ],
                    ],
                ],
            ]),
        ]);
    }
}
