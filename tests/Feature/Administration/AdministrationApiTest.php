<?php

namespace Tests\Feature\Administration;

use App\Models\CompanySetting;
use App\Models\EnterpriseDepartment;
use App\Models\EnterpriseTeam;
use App\Models\FeatureFlag;
use App\Models\WorkflowConfiguration;
use Database\Seeders\EnterpriseAdministrationSeeder;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdministrationApiTest extends TestCase
{
    public function test_super_admin_can_view_overview_and_update_company_settings(): void
    {
        $admin = $this->createSuperAdmin();
        $this->seed(EnterpriseAdministrationSeeder::class);

        Sanctum::actingAs($admin);

        $this->getJson('/api/admin/overview')
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'company_settings',
                    'departments',
                    'teams',
                    'positions',
                    'reporting_calendars',
                    'workflow_configurations',
                    'notification_settings',
                    'ai_settings',
                    'feature_flags',
                    'audit_events',
                ],
            ]);

        $this->putJson('/api/admin/company-settings', [
            'settings' => [
                ['key' => 'company.name', 'group' => 'company', 'label' => 'Company name', 'type' => 'text', 'value' => 'Acme Reporting Group', 'is_public' => true],
                ['key' => 'company.timezone', 'group' => 'company', 'label' => 'Timezone', 'type' => 'text', 'value' => 'Africa/Douala', 'is_public' => true],
            ],
        ])
            ->assertOk()
            ->assertJsonPath('message', 'Company settings updated.');

        $this->assertDatabaseHas('company_settings', ['key' => 'company.name']);
        $this->assertSame('Acme Reporting Group', CompanySetting::where('key', 'company.name')->firstOrFail()->value['value']);
        $this->assertDatabaseHas('activity_log', ['log_name' => 'administration', 'event' => 'company_settings_updated']);
    }

    public function test_non_super_admins_cannot_access_administration(): void
    {
        foreach ([$this->createManager(), $this->createEmployeeUser()] as $user) {
            Sanctum::actingAs($user);

            $this->getJson('/api/admin/overview')->assertForbidden();
            $this->putJson('/api/admin/company-settings', [
                'settings' => [
                    ['key' => 'company.name', 'label' => 'Company name', 'value' => 'Blocked'],
                ],
            ])->assertForbidden();
        }
    }

    public function test_super_admin_can_manage_departments_teams_and_positions(): void
    {
        Sanctum::actingAs($this->createSuperAdmin());

        $departmentId = $this->postJson('/api/admin/departments', [
            'name' => 'Enterprise Strategy',
            'code' => 'EST',
            'description' => 'Owns strategic planning and cross-functional initiatives.',
            'manager_id' => null,
            'active' => true,
            'metadata' => ['cost_center' => 'STR-100'],
        ])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Enterprise Strategy')
            ->json('data.id');

        $this->putJson('/api/admin/departments/'.$departmentId, [
            'name' => 'Enterprise Strategy Office',
            'code' => 'EST',
            'description' => 'Owns strategic planning, executive cadence, and cross-functional initiatives.',
            'manager_id' => null,
            'active' => true,
            'metadata' => ['cost_center' => 'STR-101'],
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Enterprise Strategy Office');

        $teamId = $this->postJson('/api/admin/teams', [
            'department_id' => $departmentId,
            'name' => 'Strategic Programs',
            'code' => 'EST-PMO',
            'description' => 'Coordinates enterprise programs.',
            'lead_id' => null,
            'active' => true,
            'metadata' => ['cadence' => 'weekly'],
        ])
            ->assertCreated()
            ->assertJsonPath('data.department_id', $departmentId)
            ->json('data.id');

        $this->putJson('/api/admin/teams/'.$teamId, [
            'department_id' => $departmentId,
            'name' => 'Strategic Programs Office',
            'code' => 'EST-PMO',
            'description' => 'Coordinates enterprise programs and risks.',
            'lead_id' => null,
            'active' => true,
            'metadata' => ['cadence' => 'weekly'],
        ])->assertOk()->assertJsonPath('data.name', 'Strategic Programs Office');

        $positionId = $this->postJson('/api/admin/positions', [
            'department_id' => $departmentId,
            'title' => 'Strategy Lead',
            'code' => 'EST-LEAD',
            'level' => 'Lead',
            'description' => 'Leads strategic portfolio reviews.',
            'active' => true,
            'metadata' => ['weekly_report_required' => true],
        ])
            ->assertCreated()
            ->assertJsonPath('data.title', 'Strategy Lead')
            ->json('data.id');

        $this->deleteJson('/api/admin/positions/'.$positionId)->assertOk();
        $this->deleteJson('/api/admin/teams/'.$teamId)->assertOk();
        $this->deleteJson('/api/admin/departments/'.$departmentId)->assertOk();

        $this->assertDatabaseMissing('enterprise_departments', ['id' => $departmentId]);
        $this->assertDatabaseMissing('enterprise_teams', ['id' => $teamId]);
        $this->assertDatabaseMissing('enterprise_positions', ['id' => $positionId]);
    }

    public function test_super_admin_can_manage_calendar_workflow_notifications_ai_and_feature_flags(): void
    {
        Sanctum::actingAs($this->createSuperAdmin());

        $calendarId = $this->postJson('/api/admin/reporting-calendars', [
            'name' => 'Quarterly board reporting',
            'frequency' => 'monthly',
            'reporting_day' => 25,
            'due_day' => 28,
            'reminder_days' => [3, 7],
            'starts_at' => '2026-01-01',
            'ends_at' => null,
            'active' => true,
            'metadata' => ['audience' => 'board'],
        ])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Quarterly board reporting')
            ->json('data.id');

        $this->putJson('/api/admin/reporting-calendars/'.$calendarId, [
            'name' => 'Quarterly board reporting',
            'frequency' => 'monthly',
            'reporting_day' => 24,
            'due_day' => 28,
            'reminder_days' => [4, 8],
            'starts_at' => '2026-01-01',
            'ends_at' => null,
            'active' => true,
            'metadata' => ['audience' => 'board'],
        ])->assertOk()->assertJsonPath('data.reporting_day', 24);

        $workflowOne = $this->postJson('/api/admin/workflow-configurations', $this->workflowPayload('Workflow A'))
            ->assertCreated()
            ->json('data.id');

        $workflowTwo = $this->postJson('/api/admin/workflow-configurations', $this->workflowPayload('Workflow B'))
            ->assertCreated()
            ->json('data.id');

        $this->assertFalse(WorkflowConfiguration::findOrFail($workflowOne)->active);
        $this->assertTrue(WorkflowConfiguration::findOrFail($workflowTwo)->active);

        $this->putJson('/api/admin/notification-settings', [
            'key' => 'report.escalated',
            'label' => 'Report escalated',
            'enabled' => true,
            'channels' => ['database'],
            'frequency' => 'instant',
            'recipients' => ['manager', 'super-admin'],
            'metadata' => ['workflow' => true],
        ])->assertOk()->assertJsonPath('data.key', 'report.escalated');

        $this->putJson('/api/admin/ai-settings', [
            'key' => 'weekly_report_assistant',
            'provider' => 'openai',
            'model' => 'gpt-4o-mini',
            'enabled' => true,
            'fallback_enabled' => true,
            'options' => ['fallback_order' => ['openai', 'gemini']],
        ])->assertOk()->assertJsonPath('data.provider', 'openai');

        $this->putJson('/api/admin/feature-flags', [
            'key' => 'enterprise_admin_test',
            'name' => 'Enterprise admin test',
            'description' => 'Feature flag managed by the administration center.',
            'enabled' => true,
            'scope' => 'global',
            'rollout_percentage' => 100,
            'metadata' => ['test' => true],
        ])->assertOk()->assertJsonPath('data.enabled', true);

        $this->assertDatabaseHas('reporting_calendars', ['id' => $calendarId, 'reporting_day' => 24]);
        $this->assertDatabaseHas('enterprise_notification_settings', ['key' => 'report.escalated']);
        $this->assertDatabaseHas('enterprise_ai_settings', ['key' => 'weekly_report_assistant', 'provider' => 'openai']);
        $this->assertTrue(FeatureFlag::where('key', 'enterprise_admin_test')->firstOrFail()->enabled);
    }

    public function test_administration_audit_endpoint_returns_administration_events(): void
    {
        Sanctum::actingAs($this->createSuperAdmin());

        $this->postJson('/api/admin/departments', [
            'name' => 'Audit Department',
            'code' => 'AUD',
            'description' => 'Exists to prove audit logging.',
            'manager_id' => null,
            'active' => true,
            'metadata' => [],
        ])->assertCreated();

        $this->getJson('/api/admin/audit')
            ->assertOk()
            ->assertJsonPath('data.data.0.event', 'department_created')
            ->assertJsonPath('data.data.0.log_name', 'administration');
    }

    private function workflowPayload(string $name): array
    {
        return [
            'name' => $name,
            'version' => 1,
            'stages' => [
                ['key' => 'draft', 'label' => 'Draft'],
                ['key' => 'submitted', 'label' => 'Submitted'],
                ['key' => 'under_review', 'label' => 'Under Review'],
                ['key' => 'approved', 'label' => 'Approved'],
                ['key' => 'rejected', 'label' => 'Rejected'],
            ],
            'transitions' => [
                ['from' => 'draft', 'to' => 'submitted', 'actor' => 'employee'],
                ['from' => 'submitted', 'to' => 'under_review', 'actor' => 'manager'],
                ['from' => 'under_review', 'to' => 'approved', 'actor' => 'manager'],
            ],
            'applies_to' => ['departments' => ['all']],
            'active' => true,
        ];
    }
}
