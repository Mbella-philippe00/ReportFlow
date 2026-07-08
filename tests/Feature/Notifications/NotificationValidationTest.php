<?php

namespace Tests\Feature\Notifications;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationValidationTest extends TestCase
{
    public function test_notification_list_validates_filters_sorting_and_pagination(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $this->getJson('/api/notifications?status=missing&type=unknown&sort=bad&direction=sideways&per_page=500&page=0')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'direction',
                'page',
                'per_page',
                'sort',
                'status',
                'type',
            ]);
    }

    public function test_notification_search_must_not_exceed_max_length(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $this->getJson('/api/notifications?search='.str_repeat('a', 256))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['search']);
    }
}
