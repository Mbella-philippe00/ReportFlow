<?php

namespace Tests\Feature\Analytics;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnalyticsAuthorizationTest extends TestCase
{
    public function test_guest_cannot_access_analytics(): void
    {
        $this->getJson('/api/analytics/overview')->assertUnauthorized();
        $this->getJson('/api/analytics/export-options')->assertUnauthorized();
    }

    public function test_employee_cannot_access_analytics(): void
    {
        $employee = $this->createEmployeeUser();

        Sanctum::actingAs($employee);

        $this->getJson('/api/analytics/overview')->assertForbidden();
    }

    public function test_manager_and_super_admin_can_access_analytics(): void
    {
        Sanctum::actingAs($this->createManager());

        $this->getJson('/api/analytics/overview')->assertOk();

        Sanctum::actingAs($this->createSuperAdmin());

        $this->getJson('/api/analytics/overview')->assertOk();
    }
}
