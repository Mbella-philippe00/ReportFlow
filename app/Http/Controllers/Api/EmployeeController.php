<?php

namespace App\Http\Controllers\Api;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\WeeklyReportResource;
use App\Models\Employee;
use App\Models\WeeklyReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

class EmployeeController extends Controller
{
    private const WORKFLOW_ACTIVITY_DESCRIPTIONS = [
        'Rapport soumis',
        'Rapport pré-validé par manager',
        'Rapport validé définitivement',
        'Rapport rejeté',
        'Rapport prÃ©-validÃ© par manager',
        'Rapport validÃ© dÃ©finitivement',
        'Rapport rejetÃ©',
    ];

    public function index(IndexEmployeeRequest $request): JsonResponse
    {
        Gate::authorize('viewAny', Employee::class);

        $query = Employee::query()
            ->with('user.roles')
            ->withCount('weeklyReports');

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        $employees = $query->paginate(
            $request->integer('per_page', 15)
        );

        return response()->json([
            'success' => true,
            'data' => EmployeeResource::collection($employees),
            'meta' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ],
        ]);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        Gate::authorize('create', Employee::class);

        $employee = Employee::create($request->validated())
            ->load('user.roles')
            ->loadCount('weeklyReports');

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully.',
            'data' => new EmployeeResource($employee),
        ], 201);
    }

    public function show(Employee $employee): JsonResponse
    {
        Gate::authorize('view', $employee);

        $employee->load('user.roles')
            ->loadCount('weeklyReports');

        return response()->json([
            'success' => true,
            'data' => new EmployeeResource($employee),
            'statistics' => $this->statistics($employee),
            'recent_reports' => WeeklyReportResource::collection(
                $employee->weeklyReports()
                    ->latest()
                    ->take(5)
                    ->get()
            ),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        Gate::authorize('update', $employee);

        $employee->update($request->validated());

        $employee->refresh()
            ->load('user.roles')
            ->loadCount('weeklyReports');

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully.',
            'data' => new EmployeeResource($employee),
        ]);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        Gate::authorize('delete', $employee);

        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully.',
        ]);
    }

    public function reports(IndexEmployeeRequest $request, Employee $employee): JsonResponse
    {
        Gate::authorize('viewReports', $employee);

        $reports = $employee->weeklyReports()
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => WeeklyReportResource::collection($reports),
            'meta' => [
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
                'total' => $reports->total(),
            ],
        ]);
    }

    public function activity(IndexEmployeeRequest $request, Employee $employee): JsonResponse
    {
        Gate::authorize('viewActivity', $employee);

        $reportIds = $employee->weeklyReports()
            ->pluck('id');

        $activities = Activity::query()
            ->with('causer')
            ->where('subject_type', WeeklyReport::class)
            ->whereIn('subject_id', $reportIds)
            ->whereIn('description', self::WORKFLOW_ACTIVITY_DESCRIPTIONS)
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $activities->getCollection()->map(fn (Activity $activity) => [
                'id' => $activity->id,
                'description' => $activity->description,
                'event' => $activity->event,
                'properties' => $activity->properties,
                'causer' => $activity->causer ? [
                    'id' => $activity->causer->getKey(),
                    'name' => $activity->causer->name,
                    'email' => $activity->causer->email,
                ] : null,
                'report_id' => $activity->subject_id,
                'created_at' => $activity->created_at,
                'updated_at' => $activity->updated_at,
            ])->values(),
            'meta' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
            ],
        ]);
    }

    private function applyFilters(Builder $query, IndexEmployeeRequest $request): void
    {
        $search = $request->validated('search');

        if (is_string($search) && trim($search) !== '') {
            $term = '%'.trim($search).'%';

            $query->where(function (Builder $query) use ($term): void {
                $query
                    ->where('first_name', 'like', $term)
                    ->orWhere('last_name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('department', 'like', $term);
            });
        }

        $department = $request->validated('department');

        if (is_string($department) && trim($department) !== '') {
            $query->where('department', trim($department));
        }

        if ($request->has('active')) {
            $query->where('active', $this->booleanFilter($request->string('active')->toString()));
        }
    }

    private function applySorting(Builder $query, IndexEmployeeRequest $request): void
    {
        $sort = $request->validated('sort') ?? 'created_at';
        $direction = $request->validated('direction') ?? 'desc';

        if (str_starts_with($sort, '-')) {
            $sort = substr($sort, 1);
            $direction = 'desc';
        }

        if ($sort === 'reports_count') {
            $query->orderBy('weekly_reports_count', $direction);

            return;
        }

        if ($sort === 'name') {
            $query->orderBy('last_name', $direction)
                ->orderBy('first_name', $direction);

            return;
        }

        $query->orderBy($sort, $direction);
    }

    private function booleanFilter(string $value): bool
    {
        return in_array($value, ['1', 'true'], true);
    }

    private function statistics(Employee $employee): array
    {
        return [
            'total_reports' => $employee->weeklyReports()->count(),
            'draft_reports' => $employee->weeklyReports()->where('status', ReportStatus::DRAFT)->count(),
            'submitted_reports' => $employee->weeklyReports()->where('status', ReportStatus::SUBMITTED)->count(),
            'manager_approved_reports' => $employee->weeklyReports()->where('status', ReportStatus::UNDER_REVIEW)->count(),
            'generated_reports' => $employee->weeklyReports()->where('status', ReportStatus::APPROVED)->count(),
            'rejected_reports' => $employee->weeklyReports()->where('status', ReportStatus::REJECTED)->count(),
            'last_report_at' => $employee->weeklyReports()->latest()->value('created_at'),
        ];
    }
}