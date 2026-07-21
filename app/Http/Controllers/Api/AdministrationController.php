<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\EnterpriseAiSetting;
use App\Models\EnterpriseDepartment;
use App\Models\EnterpriseNotificationSetting;
use App\Models\EnterprisePosition;
use App\Models\EnterpriseTeam;
use App\Models\FeatureFlag;
use App\Models\ReportingCalendar;
use App\Models\WorkflowConfiguration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class AdministrationController extends Controller
{
    public function overview(): JsonResponse
    {
        Gate::authorize('viewAdministration');

        return $this->success([
            'company_settings' => CompanySetting::query()->orderBy('group')->orderBy('key')->get(),
            'departments' => EnterpriseDepartment::query()->with(['manager', 'teams', 'positions'])->orderBy('name')->get(),
            'teams' => EnterpriseTeam::query()->with(['department', 'lead'])->orderBy('name')->get(),
            'positions' => EnterprisePosition::query()->with('department')->orderBy('title')->get(),
            'reporting_calendars' => ReportingCalendar::query()->latest()->get(),
            'workflow_configurations' => WorkflowConfiguration::query()->latest()->get(),
            'notification_settings' => EnterpriseNotificationSetting::query()->orderBy('key')->get(),
            'ai_settings' => EnterpriseAiSetting::query()->orderBy('key')->get(),
            'feature_flags' => FeatureFlag::query()->orderBy('key')->get(),
            'audit_events' => $this->auditQuery()->take(12)->get(),
        ]);
    }

    public function audit(): JsonResponse
    {
        Gate::authorize('viewAdministrationAudit');

        return $this->success($this->auditQuery()->paginate(20));
    }

    public function updateCompanySettings(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');

        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.key' => ['required', 'string', 'max:120'],
            'settings.*.group' => ['nullable', 'string', 'max:80'],
            'settings.*.label' => ['required', 'string', 'max:160'],
            'settings.*.type' => ['nullable', 'string', Rule::in(['text', 'number', 'boolean', 'json', 'email', 'url'])],
            'settings.*.value' => ['nullable'],
            'settings.*.is_public' => ['nullable', 'boolean'],
        ]);

        $settings = collect($validated['settings'])->map(function (array $setting): CompanySetting {
            return CompanySetting::query()->updateOrCreate(
                ['key' => $setting['key']],
                [
                    'group' => $setting['group'] ?? 'general',
                    'label' => $setting['label'],
                    'type' => $setting['type'] ?? 'text',
                    'value' => ['value' => $setting['value'] ?? null],
                    'is_public' => $setting['is_public'] ?? false,
                ],
            );
        })->values();

        $this->logAdmin('company_settings_updated', null, ['keys' => $settings->pluck('key')->all()]);

        return $this->success($settings, 'Company settings updated.');
    }

    public function storeDepartment(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $department = EnterpriseDepartment::query()->create($this->validateDepartment($request));
        $this->logAdmin('department_created', $department);

        return $this->success($department->load(['manager', 'teams', 'positions']), 'Department created.', 201);
    }

    public function updateDepartment(Request $request, EnterpriseDepartment $department): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $department->update($this->validateDepartment($request, $department));
        $this->logAdmin('department_updated', $department);

        return $this->success($department->fresh(['manager', 'teams', 'positions']), 'Department updated.');
    }

    public function destroyDepartment(EnterpriseDepartment $department): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $this->logAdmin('department_deleted', $department, ['name' => $department->name]);
        $department->delete();

        return $this->message('Department deleted.');
    }

    public function storeTeam(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $team = EnterpriseTeam::query()->create($this->validateTeam($request));
        $this->logAdmin('team_created', $team);

        return $this->success($team->load(['department', 'lead']), 'Team created.', 201);
    }

    public function updateTeam(Request $request, EnterpriseTeam $team): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $team->update($this->validateTeam($request, $team));
        $this->logAdmin('team_updated', $team);

        return $this->success($team->fresh(['department', 'lead']), 'Team updated.');
    }

    public function destroyTeam(EnterpriseTeam $team): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $this->logAdmin('team_deleted', $team, ['name' => $team->name]);
        $team->delete();

        return $this->message('Team deleted.');
    }

    public function storePosition(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $position = EnterprisePosition::query()->create($this->validatePosition($request));
        $this->logAdmin('position_created', $position);

        return $this->success($position->load('department'), 'Position created.', 201);
    }

    public function updatePosition(Request $request, EnterprisePosition $position): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $position->update($this->validatePosition($request, $position));
        $this->logAdmin('position_updated', $position);

        return $this->success($position->fresh('department'), 'Position updated.');
    }

    public function destroyPosition(EnterprisePosition $position): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $this->logAdmin('position_deleted', $position, ['title' => $position->title]);
        $position->delete();

        return $this->message('Position deleted.');
    }

    public function storeReportingCalendar(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $calendar = ReportingCalendar::query()->create($this->validateCalendar($request));
        $this->logAdmin('reporting_calendar_created', $calendar);

        return $this->success($calendar, 'Reporting calendar created.', 201);
    }

    public function updateReportingCalendar(Request $request, ReportingCalendar $calendar): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $calendar->update($this->validateCalendar($request));
        $this->logAdmin('reporting_calendar_updated', $calendar);

        return $this->success($calendar->fresh(), 'Reporting calendar updated.');
    }

    public function destroyReportingCalendar(ReportingCalendar $calendar): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $this->logAdmin('reporting_calendar_deleted', $calendar, ['name' => $calendar->name]);
        $calendar->delete();

        return $this->message('Reporting calendar deleted.');
    }

    public function storeWorkflowConfiguration(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $data = $this->validateWorkflow($request);
        if ($data['active'] ?? false) {
            WorkflowConfiguration::query()->update(['active' => false]);
        }
        $workflow = WorkflowConfiguration::query()->create($data);
        $this->logAdmin('workflow_configuration_created', $workflow);

        return $this->success($workflow, 'Workflow configuration created.', 201);
    }

    public function updateWorkflowConfiguration(Request $request, WorkflowConfiguration $workflow): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $data = $this->validateWorkflow($request);
        if ($data['active'] ?? false) {
            WorkflowConfiguration::query()->whereKeyNot($workflow->id)->update(['active' => false]);
        }
        $workflow->update($data);
        $this->logAdmin('workflow_configuration_updated', $workflow);

        return $this->success($workflow->fresh(), 'Workflow configuration updated.');
    }

    public function upsertNotificationSetting(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $data = $request->validate([
            'key' => ['required', 'string', 'max:120'],
            'label' => ['required', 'string', 'max:160'],
            'enabled' => ['required', 'boolean'],
            'channels' => ['required', 'array'],
            'frequency' => ['required', 'string', Rule::in(['instant', 'daily_digest', 'weekly_digest'])],
            'recipients' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],
        ]);
        $setting = EnterpriseNotificationSetting::query()->updateOrCreate(['key' => $data['key']], $data);
        $this->logAdmin('notification_setting_saved', $setting);

        return $this->success($setting, 'Notification setting saved.');
    }

    public function upsertAiSetting(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $data = $request->validate([
            'key' => ['required', 'string', 'max:120'],
            'provider' => ['required', 'string', Rule::in(['openai', 'gemini'])],
            'model' => ['nullable', 'string', 'max:120'],
            'enabled' => ['required', 'boolean'],
            'fallback_enabled' => ['required', 'boolean'],
            'options' => ['nullable', 'array'],
        ]);
        $setting = EnterpriseAiSetting::query()->updateOrCreate(['key' => $data['key']], $data);
        $this->logAdmin('ai_setting_saved', $setting, ['provider' => $setting->provider]);

        return $this->success($setting, 'AI setting saved.');
    }

    public function upsertFeatureFlag(Request $request): JsonResponse
    {
        Gate::authorize('manageAdministration');
        $data = $request->validate([
            'key' => ['required', 'string', 'max:120'],
            'name' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:1000'],
            'enabled' => ['required', 'boolean'],
            'scope' => ['required', 'string', Rule::in(['global', 'role', 'department'])],
            'rollout_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'metadata' => ['nullable', 'array'],
        ]);
        $flag = FeatureFlag::query()->updateOrCreate(['key' => $data['key']], $data);
        $this->logAdmin('feature_flag_saved', $flag, ['enabled' => $flag->enabled]);

        return $this->success($flag, 'Feature flag saved.');
    }

    private function validateDepartment(Request $request, ?EnterpriseDepartment $department = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160', Rule::unique('enterprise_departments', 'name')->ignore($department?->id)],
            'code' => ['required', 'string', 'max:40', Rule::unique('enterprise_departments', 'code')->ignore($department?->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'manager_id' => ['nullable', 'integer', 'exists:users,id'],
            'active' => ['required', 'boolean'],
            'metadata' => ['nullable', 'array'],
        ]);
    }

    private function validateTeam(Request $request, ?EnterpriseTeam $team = null): array
    {
        return $request->validate([
            'department_id' => ['required', 'integer', 'exists:enterprise_departments,id'],
            'name' => ['required', 'string', 'max:160'],
            'code' => ['required', 'string', 'max:40', Rule::unique('enterprise_teams', 'code')->ignore($team?->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'lead_id' => ['nullable', 'integer', 'exists:users,id'],
            'active' => ['required', 'boolean'],
            'metadata' => ['nullable', 'array'],
        ]);
    }

    private function validatePosition(Request $request, ?EnterprisePosition $position = null): array
    {
        return $request->validate([
            'department_id' => ['nullable', 'integer', 'exists:enterprise_departments,id'],
            'title' => ['required', 'string', 'max:160'],
            'code' => ['required', 'string', 'max:40', Rule::unique('enterprise_positions', 'code')->ignore($position?->id)],
            'level' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:1000'],
            'active' => ['required', 'boolean'],
            'metadata' => ['nullable', 'array'],
        ]);
    }

    private function validateCalendar(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'frequency' => ['required', 'string', Rule::in(['weekly', 'biweekly', 'monthly'])],
            'reporting_day' => ['required', 'integer', 'min:1', 'max:31'],
            'due_day' => ['required', 'integer', 'min:1', 'max:31'],
            'reminder_days' => ['nullable', 'array'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'active' => ['required', 'boolean'],
            'metadata' => ['nullable', 'array'],
        ]);
    }

    private function validateWorkflow(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'version' => ['nullable', 'integer', 'min:1'],
            'stages' => ['required', 'array', 'min:2'],
            'transitions' => ['required', 'array', 'min:1'],
            'applies_to' => ['nullable', 'array'],
            'active' => ['required', 'boolean'],
        ]);
    }

    private function auditQuery()
    {
        return Activity::query()
            ->with('causer')
            ->where('log_name', 'administration')
            ->latest();
    }

    private function logAdmin(string $event, ?Model $subject = null, array $properties = []): void
    {
        $logger = activity('administration')
            ->event($event)
            ->causedBy(auth()->user())
            ->withProperties($properties);

        if ($subject) {
            $logger->performedOn($subject);
        }

        $logger->log('Administration '.str_replace('_', ' ', $event));
    }

    private function success($data, ?string $message = null, int $status = 200): JsonResponse
    {
        return response()->json(array_filter([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], fn ($value) => $value !== null), $status);
    }

    private function message(string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
