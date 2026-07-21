<?php

namespace Tests\Feature\Analytics;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnalyticsValidationTest extends TestCase
{
    public function test_analytics_validates_filters(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->getJson('/api/analytics/trends?period=custom&from=2026-01-10&to=2026-01-01&employee=999999&status=unknown&granularity=daily')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'employee',
                'granularity',
                'status',
                'to',
            ]);
    }

    public function test_custom_period_requires_date_range(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->getJson('/api/analytics/overview?period=custom')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'from',
                'to',
            ]);
    }

    public function test_department_filter_has_maximum_length(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->getJson('/api/analytics/overview?department='.str_repeat('a', 256))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['department']);
    }
}
