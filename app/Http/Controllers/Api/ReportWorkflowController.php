<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyReportResource;
use App\Models\WeeklyReport;
use App\Services\Reports\ReportValidationService;
use App\Services\Reports\ReportWorkflowService;
use App\Services\Reports\WorkflowStateMachine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportWorkflowController extends Controller
{
    public function __construct(
        protected ReportWorkflowService $workflow,
        protected ReportValidationService $validation,
        protected WorkflowStateMachine $stateMachine,
    ) {}

    public function queue(Request $request): JsonResponse
    {
        Gate::authorize('viewQueue', WeeklyReport::class);

        return response()->json([
            'success' => true,
            'data' => WeeklyReportResource::collection(
                $this->workflow->queueFor($request->user()),
            ),
        ]);
    }

    public function timeline(WeeklyReport $report): JsonResponse
    {
        Gate::authorize('viewTimeline', $report);

        return response()->json([
            'success' => true,
            'data' => $this->stateMachine->timeline($report),
        ]);
    }

    public function submit(WeeklyReport $report): JsonResponse
    {
        Gate::authorize('submit', $report);

        $this->workflow->submit($report);

        return response()->json([
            'success' => true,
            'message' => 'Report submitted successfully.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    public function approve(Request $request, WeeklyReport $report): JsonResponse
    {
        Gate::authorize('approve', $report);

        $validated = $request->validate([
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->validation->managerApprove(
            $report,
            $validated['comment'] ?? null,
        );

        return response()->json([
            'success' => true,
            'message' => 'Report moved under review.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    public function finalApprove(WeeklyReport $report): JsonResponse
    {
        Gate::authorize('finalApprove', $report);

        $this->validation->finalApprove($report);

        return response()->json([
            'success' => true,
            'message' => 'Report approved.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    public function reject(Request $request, WeeklyReport $report): JsonResponse
    {
        Gate::authorize('reject', $report);

        $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $this->validation->reject(
            $report,
            $request->string('reason')->toString(),
        );

        return response()->json([
            'success' => true,
            'message' => 'Report rejected.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }
}
