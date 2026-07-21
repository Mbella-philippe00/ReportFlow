<?php

namespace Tests\Feature\AI;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AiValidationTest extends TestCase
{
    public function test_assist_requires_valid_action(): void
    {
        $manager = $this->createManager();
        $report = $this->createDraftReport();

        Sanctum::actingAs($manager);

        $this->postJson("/api/ai/reports/{$report->id}/assist", [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['action']);

        $this->postJson("/api/ai/reports/{$report->id}/assist", [
            'action' => 'unknown_action',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['action']);
    }

    public function test_report_generation_validates_payload_fields(): void
    {
        $manager = $this->createManager();
        $report = $this->createDraftReport();

        Sanctum::actingAs($manager);

        $this->postJson("/api/ai/reports/{$report->id}/improve-writing", [
            'section' => 'unknown_section',
            'locale' => 'de',
            'instructions' => str_repeat('a', 2001),
            'text' => str_repeat('b', 12001),
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'instructions',
                'locale',
                'section',
                'text',
            ]);
    }

    public function test_history_validates_filters(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->getJson('/api/ai/history?action=bad&scope=everyone&per_page=500&page=0&report_id=999999')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'action',
                'page',
                'per_page',
                'report_id',
                'scope',
            ]);
    }
}
