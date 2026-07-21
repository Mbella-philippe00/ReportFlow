<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AI\AiDashboardRequest;
use App\Http\Requests\AI\AiHistoryRequest;
use App\Http\Requests\AI\AiProviderRequest;
use App\Http\Requests\AI\AiReportGenerationRequest;
use App\Http\Resources\AI\AiDashboardResource;
use App\Http\Resources\AI\AiGenerationResource;
use App\Http\Resources\AI\AiHistoryResource;
use App\Http\Resources\AI\AiProviderResource;
use App\Models\WeeklyReport;
use App\Services\AI\AiHistoryService;
use App\Services\AI\AiProviderException;
use App\Services\AI\AiPromptCatalog;
use App\Services\AI\ReportAiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

class AiController extends Controller
{
    public function __construct(
        protected ReportAiAssistantService $assistant,
        protected AiHistoryService $history,
    ) {}

    public function dashboard(AiDashboardRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new AiDashboardResource(
                $this->history->dashboard($request->user()),
            ),
        ]);
    }

    public function providers(AiProviderRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => AiProviderResource::collection(
                $this->history->providers(),
            ),
        ]);
    }

    public function history(AiHistoryRequest $request): JsonResponse
    {
        $history = $this->history->list(
            $request->user(),
            $request->validated(),
        );

        return response()->json([
            'success' => true,
            'data' => AiHistoryResource::collection($history),
            'meta' => [
                'current_page' => $history->currentPage(),
                'last_page' => $history->lastPage(),
                'per_page' => $history->perPage(),
                'total' => $history->total(),
            ],
        ]);
    }

    public function assist(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        $action = $request->validated('action');

        if (! is_string($action) || $action === '') {
            return response()->json([
                'message' => 'The action field is required.',
                'errors' => [
                    'action' => ['The action field is required.'],
                ],
            ], 422);
        }

        return $this->generate($request, $report, $action);
    }

    public function executiveSummary(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_EXECUTIVE_SUMMARY);
    }

    public function improveWriting(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_WRITING_IMPROVEMENT);
    }

    public function writingSuggestions(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_WRITING_SUGGESTIONS);
    }

    public function grammarTone(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_GRAMMAR_TONE);
    }

    public function actionItems(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_ACTION_ITEMS);
    }

    public function riskAnalysis(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_RISK_ANALYSIS);
    }

    public function priorityDetection(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_PRIORITY_DETECTION);
    }

    public function missingInformation(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_MISSING_INFORMATION);
    }

    public function qualityScore(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_QUALITY_SCORE);
    }

    public function workflowRecommendation(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_WORKFLOW_RECOMMENDATION);
    }

    public function powerpointSummary(AiReportGenerationRequest $request, WeeklyReport $report): JsonResponse
    {
        return $this->generate($request, $report, AiPromptCatalog::ACTION_POWERPOINT_SUMMARY);
    }

    private function generate(AiReportGenerationRequest $request, WeeklyReport $report, string $action): JsonResponse
    {
        $this->authorizeAction($report, $action);

        try {
            $result = $this->assistant->generate(
                user: $request->user(),
                report: $report,
                action: $action,
                context: $request->validated(),
            );
        } catch (AiProviderException $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->httpStatus());
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Provider unavailable.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'AI generation completed successfully.',
            'data' => new AiGenerationResource($result),
        ]);
    }

    private function authorizeAction(WeeklyReport $report, string $action): void
    {
        if ($action === AiPromptCatalog::ACTION_WORKFLOW_RECOMMENDATION) {
            Gate::authorize('recommendAiWorkflow', $report);

            return;
        }

        Gate::authorize('useAiForReport', $report);
    }
}