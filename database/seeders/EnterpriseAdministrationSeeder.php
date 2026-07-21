<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use App\Models\EnterpriseAiSetting;
use App\Models\EnterpriseDepartment;
use App\Models\EnterpriseNotificationSetting;
use App\Models\EnterprisePosition;
use App\Models\EnterpriseTeam;
use App\Models\FeatureFlag;
use App\Models\ReportingCalendar;
use App\Models\User;
use App\Models\WorkflowConfiguration;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class EnterpriseAdministrationSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::role('super-admin')->first();
        $managers = User::role('manager')->get()->values();

        $this->seedCompanySettings();
        $departments = $this->seedDepartments($managers);
        $this->seedTeams($departments, $managers);
        $this->seedPositions($departments);
        $this->seedReportingCalendars();
        $this->seedWorkflowConfigurations();
        $this->seedNotificationSettings();
        $this->seedAiSettings();
        $this->seedFeatureFlags();

        if ($superAdmin) {
            activity('administration')
                ->event('defaults_seeded')
                ->causedBy($superAdmin)
                ->withProperties([
                    'departments' => EnterpriseDepartment::count(),
                    'teams' => EnterpriseTeam::count(),
                    'positions' => EnterprisePosition::count(),
                    'feature_flags' => FeatureFlag::count(),
                ])
                ->log('Administration defaults seeded');
        }
    }

    private function seedCompanySettings(): void
    {
        $settings = [
            ['key' => 'company.name', 'group' => 'company', 'label' => 'Company name', 'type' => 'text', 'value' => ['value' => 'ReportFlow Demo Group'], 'is_public' => true],
            ['key' => 'company.timezone', 'group' => 'company', 'label' => 'Default timezone', 'type' => 'text', 'value' => ['value' => config('app.timezone', 'UTC')], 'is_public' => true],
            ['key' => 'company.locale', 'group' => 'company', 'label' => 'Default locale', 'type' => 'text', 'value' => ['value' => config('app.locale', 'en')], 'is_public' => true],
            ['key' => 'reports.default_due_day', 'group' => 'reporting', 'label' => 'Default report due day', 'type' => 'number', 'value' => ['value' => 1], 'is_public' => false],
            ['key' => 'workflow.escalation_hours', 'group' => 'workflow', 'label' => 'Workflow escalation hours', 'type' => 'number', 'value' => ['value' => 48], 'is_public' => false],
        ];

        foreach ($settings as $setting) {
            CompanySetting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    private function seedDepartments(Collection $managers): Collection
    {
        $blueprints = [
            ['name' => 'Engineering', 'code' => 'ENG', 'manager_email' => 'marc.operations@reportflow.test', 'description' => 'Builds product capabilities and internal automation.'],
            ['name' => 'Operations', 'code' => 'OPS', 'manager_email' => 'marc.operations@reportflow.test', 'description' => 'Coordinates delivery, process health, and operating rhythms.'],
            ['name' => 'Finance', 'code' => 'FIN', 'manager_email' => 'nadia.finance@reportflow.test', 'description' => 'Owns budgets, controls, and financial planning.'],
            ['name' => 'Product', 'code' => 'PRD', 'manager_email' => 'marc.operations@reportflow.test', 'description' => 'Shapes roadmap, discovery, and customer outcomes.'],
            ['name' => 'Quality', 'code' => 'QLT', 'manager_email' => 'jean.quality@reportflow.test', 'description' => 'Runs quality assurance and compliance checks.'],
            ['name' => 'Support', 'code' => 'SUP', 'manager_email' => 'jean.quality@reportflow.test', 'description' => 'Supports customers and feeds product insights back to teams.'],
            ['name' => 'Human Resources', 'code' => 'HR', 'manager_email' => 'nadia.finance@reportflow.test', 'description' => 'Manages people operations, hiring, and engagement.'],
            ['name' => 'Sales', 'code' => 'SAL', 'manager_email' => 'nadia.finance@reportflow.test', 'description' => 'Leads pipeline, accounts, and revenue motions.'],
        ];

        return collect($blueprints)->map(function (array $department) use ($managers): EnterpriseDepartment {
            $manager = $managers->firstWhere('email', $department['manager_email']);

            return EnterpriseDepartment::query()->updateOrCreate(
                ['code' => $department['code']],
                [
                    'name' => $department['name'],
                    'description' => $department['description'],
                    'manager_id' => $manager?->id,
                    'active' => true,
                    'metadata' => [
                        'operating_model' => 'weekly_reporting',
                        'manager_email' => $department['manager_email'],
                    ],
                ],
            );
        });
    }

    private function seedTeams(Collection $departments, Collection $managers): void
    {
        $teams = [
            ['department' => 'Engineering', 'name' => 'Platform Automation', 'code' => 'ENG-PLAT', 'lead_email' => 'marc.operations@reportflow.test'],
            ['department' => 'Engineering', 'name' => 'Product Experience', 'code' => 'ENG-UX', 'lead_email' => 'marc.operations@reportflow.test'],
            ['department' => 'Operations', 'name' => 'Delivery Operations', 'code' => 'OPS-DEL', 'lead_email' => 'marc.operations@reportflow.test'],
            ['department' => 'Finance', 'name' => 'Planning and Controls', 'code' => 'FIN-CTRL', 'lead_email' => 'nadia.finance@reportflow.test'],
            ['department' => 'Quality', 'name' => 'Compliance Review', 'code' => 'QLT-CMP', 'lead_email' => 'jean.quality@reportflow.test'],
            ['department' => 'Support', 'name' => 'Customer Response', 'code' => 'SUP-CR', 'lead_email' => 'jean.quality@reportflow.test'],
            ['department' => 'Sales', 'name' => 'Enterprise Accounts', 'code' => 'SAL-ENT', 'lead_email' => 'nadia.finance@reportflow.test'],
        ];

        foreach ($teams as $team) {
            $department = $departments->firstWhere('name', $team['department']);
            $lead = $managers->firstWhere('email', $team['lead_email']);

            if (! $department) {
                continue;
            }

            EnterpriseTeam::query()->updateOrCreate(
                ['code' => $team['code']],
                [
                    'department_id' => $department->id,
                    'name' => $team['name'],
                    'description' => 'Enterprise team for '.$team['department'].' execution and weekly rollups.',
                    'lead_id' => $lead?->id,
                    'active' => true,
                    'metadata' => ['reporting_rhythm' => 'weekly'],
                ],
            );
        }
    }

    private function seedPositions(Collection $departments): void
    {
        $positions = [
            ['department' => 'Engineering', 'title' => 'Senior Software Engineer', 'code' => 'ENG-SSE', 'level' => 'Senior'],
            ['department' => 'Engineering', 'title' => 'Product Engineer', 'code' => 'ENG-PE', 'level' => 'Mid'],
            ['department' => 'Operations', 'title' => 'Operations Coordinator', 'code' => 'OPS-COORD', 'level' => 'Mid'],
            ['department' => 'Finance', 'title' => 'Financial Analyst', 'code' => 'FIN-ANL', 'level' => 'Mid'],
            ['department' => 'Product', 'title' => 'Product Manager', 'code' => 'PRD-PM', 'level' => 'Lead'],
            ['department' => 'Quality', 'title' => 'Quality Analyst', 'code' => 'QLT-QA', 'level' => 'Mid'],
            ['department' => 'Support', 'title' => 'Support Specialist', 'code' => 'SUP-SPEC', 'level' => 'Associate'],
            ['department' => 'Human Resources', 'title' => 'People Operations Partner', 'code' => 'HR-POP', 'level' => 'Mid'],
            ['department' => 'Sales', 'title' => 'Account Executive', 'code' => 'SAL-AE', 'level' => 'Mid'],
        ];

        foreach ($positions as $position) {
            $department = $departments->firstWhere('name', $position['department']);

            EnterprisePosition::query()->updateOrCreate(
                ['code' => $position['code']],
                [
                    'department_id' => $department?->id,
                    'title' => $position['title'],
                    'level' => $position['level'],
                    'description' => $position['title'].' role within '.$position['department'].'.',
                    'active' => true,
                    'metadata' => ['weekly_report_required' => true],
                ],
            );
        }
    }

    private function seedReportingCalendars(): void
    {
        $start = CarbonImmutable::now()->startOfQuarter()->toDateString();

        $calendars = [
            ['name' => 'Standard weekly reporting', 'frequency' => 'weekly', 'reporting_day' => 5, 'due_day' => 1, 'reminder_days' => [1, 3], 'starts_at' => $start, 'ends_at' => null, 'active' => true, 'metadata' => ['timezone' => config('app.timezone')]],
            ['name' => 'Executive monthly rollup', 'frequency' => 'monthly', 'reporting_day' => 25, 'due_day' => 28, 'reminder_days' => [3, 7], 'starts_at' => $start, 'ends_at' => null, 'active' => true, 'metadata' => ['audience' => 'executive']],
        ];

        foreach ($calendars as $calendar) {
            ReportingCalendar::query()->updateOrCreate(['name' => $calendar['name']], $calendar);
        }
    }

    private function seedWorkflowConfigurations(): void
    {
        WorkflowConfiguration::query()->where('active', true)->update(['active' => false]);

        WorkflowConfiguration::query()->updateOrCreate(
            ['name' => 'Default weekly report workflow', 'version' => 1],
            [
                'stages' => [
                    ['key' => 'draft', 'label' => 'Draft', 'editable' => true, 'terminal' => false],
                    ['key' => 'submitted', 'label' => 'Submitted', 'editable' => false, 'terminal' => false],
                    ['key' => 'under_review', 'label' => 'Under Review', 'editable' => false, 'terminal' => false],
                    ['key' => 'approved', 'label' => 'Approved', 'editable' => false, 'terminal' => true],
                    ['key' => 'rejected', 'label' => 'Rejected', 'editable' => true, 'terminal' => false],
                ],
                'transitions' => [
                    ['from' => 'draft', 'to' => 'submitted', 'actor' => 'employee', 'notification' => 'report.submitted'],
                    ['from' => 'rejected', 'to' => 'submitted', 'actor' => 'employee', 'notification' => 'report.resubmitted'],
                    ['from' => 'submitted', 'to' => 'under_review', 'actor' => 'manager', 'notification' => 'report.under_review'],
                    ['from' => 'under_review', 'to' => 'approved', 'actor' => 'manager', 'notification' => 'report.approved'],
                    ['from' => 'submitted', 'to' => 'rejected', 'actor' => 'manager', 'notification' => 'report.rejected'],
                    ['from' => 'under_review', 'to' => 'rejected', 'actor' => 'manager', 'notification' => 'report.rejected'],
                ],
                'applies_to' => ['report_type' => 'weekly_report', 'departments' => ['all']],
                'active' => true,
            ],
        );
    }

    private function seedNotificationSettings(): void
    {
        $settings = [
            ['key' => 'report.submitted', 'label' => 'Report submitted', 'enabled' => true, 'channels' => ['database'], 'frequency' => 'instant', 'recipients' => ['manager'], 'metadata' => ['workflow' => true]],
            ['key' => 'report.approved', 'label' => 'Report approved', 'enabled' => true, 'channels' => ['database'], 'frequency' => 'instant', 'recipients' => ['employee'], 'metadata' => ['workflow' => true]],
            ['key' => 'report.rejected', 'label' => 'Report rejected', 'enabled' => true, 'channels' => ['database'], 'frequency' => 'instant', 'recipients' => ['employee'], 'metadata' => ['workflow' => true]],
            ['key' => 'document.mention', 'label' => 'Document mention', 'enabled' => true, 'channels' => ['database'], 'frequency' => 'instant', 'recipients' => ['mentioned_user'], 'metadata' => ['documents' => true]],
            ['key' => 'executive.alert', 'label' => 'Executive analytics alert', 'enabled' => true, 'channels' => ['database'], 'frequency' => 'daily_digest', 'recipients' => ['super-admin', 'manager'], 'metadata' => ['analytics' => true]],
        ];

        foreach ($settings as $setting) {
            EnterpriseNotificationSetting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    private function seedAiSettings(): void
    {
        $provider = config('ai.provider', 'openai');
        $model = config('ai.providers.'.$provider.'.model') ?: config('ai.providers.openai.model') ?: config('ai.providers.gemini.model');

        EnterpriseAiSetting::query()->updateOrCreate(
            ['key' => 'weekly_report_assistant'],
            [
                'provider' => in_array($provider, ['openai', 'gemini'], true) ? $provider : 'openai',
                'model' => $model,
                'enabled' => true,
                'fallback_enabled' => true,
                'options' => [
                    'fallback_order' => ['openai', 'gemini'],
                    'reports_enabled' => true,
                    'analytics_context_enabled' => true,
                ],
            ],
        );
    }

    private function seedFeatureFlags(): void
    {
        $flags = [
            ['key' => 'workflow_engine', 'name' => 'Workflow engine', 'description' => 'Enable report workflow transitions, timeline, and manager queue.', 'enabled' => true, 'scope' => 'global', 'rollout_percentage' => 100, 'metadata' => ['sprint' => 11]],
            ['key' => 'ai_assistant', 'name' => 'AI assistant', 'description' => 'Enable report AI assistance with provider fallback visibility.', 'enabled' => true, 'scope' => 'global', 'rollout_percentage' => 100, 'metadata' => ['sprint' => 11]],
            ['key' => 'documents_collaboration', 'name' => 'Documents and collaboration', 'description' => 'Enable attachments, comments, mentions, and document timeline.', 'enabled' => true, 'scope' => 'global', 'rollout_percentage' => 100, 'metadata' => ['sprint' => 13]],
            ['key' => 'executive_analytics', 'name' => 'Executive analytics', 'description' => 'Enable KPI center, smart alerts, and executive exports.', 'enabled' => true, 'scope' => 'global', 'rollout_percentage' => 100, 'metadata' => ['sprint' => 14]],
            ['key' => 'enterprise_administration', 'name' => 'Enterprise administration center', 'description' => 'Enable enterprise settings, org management, calendars, workflow configuration, and audit.', 'enabled' => true, 'scope' => 'global', 'rollout_percentage' => 100, 'metadata' => ['sprint' => 15]],
        ];

        foreach ($flags as $flag) {
            FeatureFlag::query()->updateOrCreate(['key' => $flag['key']], $flag);
        }
    }
}
