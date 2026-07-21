<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalyticsRequest;
use App\Http\Resources\AnalyticsActivityResource;
use App\Http\Resources\AnalyticsDatasetResource;
use App\Http\Resources\AnalyticsExportOptionsResource;
use App\Http\Resources\AnalyticsOverviewResource;
use App\Services\Analytics\AnalyticsService;
use App\Services\Analytics\ExecutiveAnalyticsService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function __construct(
        protected AnalyticsService $analytics,
        protected ExecutiveAnalyticsService $executiveAnalytics,
    ) {}

    public function overview(AnalyticsRequest $request): JsonResponse
    {
        $filters = $request->validated();

        return response()->json([
            'success' => true,
            'data' => new AnalyticsOverviewResource(
                $this->analytics->overview($filters),
            ),
            'filters' => $this->analytics->filterSummary($filters),
        ]);
    }

    public function trends(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->analytics->trends($request->validated()),
            $request,
        );
    }

    public function reports(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->analytics->reports($request->validated()),
            $request,
        );
    }

    public function employees(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->analytics->employees($request->validated()),
            $request,
        );
    }

    public function departments(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->analytics->departments($request->validated()),
            $request,
        );
    }

    public function workflow(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->analytics->workflow($request->validated()),
            $request,
        );
    }

    public function activity(AnalyticsRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $activity = $this->analytics->activity($filters);

        return response()->json([
            'success' => true,
            'data' => AnalyticsActivityResource::collection($activity['data']),
            'meta' => $activity['meta'],
            'filters' => $this->analytics->filterSummary($filters),
        ]);
    }

    public function executiveDashboard(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->executiveAnalytics->dashboard($request->validated()),
            $request,
        );
    }

    public function kpiCenter(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->executiveAnalytics->kpiCenter($request->validated()),
            $request,
        );
    }

    public function comparisons(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->executiveAnalytics->comparisons($request->validated()),
            $request,
        );
    }

    public function alerts(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->executiveAnalytics->alerts($request->validated()),
            $request,
        );
    }

    public function executiveReport(AnalyticsRequest $request): JsonResponse
    {
        return $this->datasetResponse(
            $this->executiveAnalytics->executiveReport($request->validated()),
            $request,
        );
    }

    public function exportOptions(AnalyticsRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new AnalyticsExportOptionsResource(
                $this->executiveAnalytics->exportOptions(),
            ),
        ]);
    }

    public function export(AnalyticsRequest $request): StreamedResponse
    {
        $validated = $request->validated();
        $export = $this->executiveAnalytics->export(
            $validated['format'] ?? 'csv',
            $validated['dataset'] ?? 'executive',
            $validated,
        );

        return response()->streamDownload(
            fn () => print $export['content'],
            $export['filename'],
            ['Content-Type' => $export['content_type']],
        );
    }

    private function datasetResponse(array $dataset, AnalyticsRequest $request): JsonResponse
    {
        $filters = $request->validated();

        return response()->json([
            'success' => true,
            'data' => new AnalyticsDatasetResource($dataset),
            'filters' => $this->analytics->filterSummary($filters),
        ]);
    }
}
