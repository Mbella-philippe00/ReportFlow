<?php

namespace App\Http\Controllers\Api;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWeeklyReportRequest;
use App\Http\Requests\UpdateWeeklyReportRequest;
use App\Http\Resources\WeeklyReportResource;
use App\Models\WeeklyReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', WeeklyReport::class);

        $query = WeeklyReport::query()->latest();
        $user = request()->user();

        if ($user && $user->hasRole('employee') && ! $user->hasAnyRole(['manager', 'super-admin'])) {
            $query->where('employee_id', $user->employee?->id);
        }

        $reports = $query->paginate(15);

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

    public function store(StoreWeeklyReportRequest $request): JsonResponse
    {
        Gate::authorize('create', WeeklyReport::class);

        $report = WeeklyReport::create([
            ...$request->validated(),
            'status' => ReportStatus::DRAFT,
        ]);

        $report->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Report created successfully.',
            'data' => new WeeklyReportResource($report),
        ], 201);
    }

    public function show(WeeklyReport $report): JsonResponse
    {
        Gate::authorize('view', $report);

        return response()->json([
            'success' => true,
            'data' => new WeeklyReportResource($report),
        ]);
    }

    public function update(UpdateWeeklyReportRequest $request, WeeklyReport $report): JsonResponse
    {
        Gate::authorize('update', $report);

        $report->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Report updated.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    public function destroy(WeeklyReport $report): JsonResponse
    {
        Gate::authorize('delete', $report);

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report deleted.',
        ]);
    }
}
