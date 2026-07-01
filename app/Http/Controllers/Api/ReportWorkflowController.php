<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyReportResource;
use App\Models\WeeklyReport;
use App\Services\Reports\ReportValidationService;
use App\Services\Reports\ReportWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportWorkflowController extends Controller
{
    public function __construct(
        protected ReportWorkflowService $workflow,
        protected ReportValidationService $validation,
    ) {}

    /**
     * Soumettre un rapport.
     */
    public function submit(WeeklyReport $report): JsonResponse
    {
        $this->workflow->submit($report);

        return response()->json([
            'success' => true,
            'message' => 'Rapport soumis avec succès.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    /**
     * Pré-validation manager.
     */
    public function approve(WeeklyReport $report): JsonResponse
    {
        $this->validation->managerApprove($report);

        return response()->json([
            'success' => true,
            'message' => 'Rapport pré-validé.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    /**
     * Validation finale.
     */
    public function finalApprove(WeeklyReport $report): JsonResponse
    {
        $this->validation->finalApprove($report);

        return response()->json([
            'success' => true,
            'message' => 'Rapport validé définitivement.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }

    /**
     * Rejeter un rapport.
     */
    public function reject(
        Request $request,
        WeeklyReport $report
    ): JsonResponse {

        $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $this->validation->reject(
            $report,
            $request->string('reason')->toString(),
        );

        return response()->json([
            'success' => true,
            'message' => 'Rapport rejeté.',
            'data' => new WeeklyReportResource($report->fresh()),
        ]);
    }
}
