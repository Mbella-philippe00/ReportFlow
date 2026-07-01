<?php

namespace Tests;

use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\CreatesEmployees;
use Tests\Traits\CreatesReports;
use Tests\Traits\CreatesUsers;

abstract class TestCase extends BaseTestCase
{
    use CreatesEmployees;
    use CreatesReports;
    use CreatesUsers;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }
}
