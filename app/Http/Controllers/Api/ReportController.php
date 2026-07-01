<?php

namespace App\Http\Controllers\Api;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWeeklyReportRequest;
use App\Http\Requests\UpdateWeeklyReportRequest;
use App\Http\Resources\WeeklyReportResource;
use App\Models\WeeklyReport;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * Liste des rapports.
     */
    public function index(): JsonResponse
    {
        $reports = WeeklyReport::latest()->paginate(15);

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

    /**
     * Création d'un rapport.
     */
    public function store(StoreWeeklyReportRequest $request): JsonResponse
    {
        $report = WeeklyReport::create([
            ...$request->validated(),
            'status' => ReportStatus::DRAFT,
        ]);

        $report->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Rapport créé avec succès.',
            'data' => new WeeklyReportResource($report),
        ], 201);
    }

    /**
     * Affichage d'un rapport.
     */
    public function show(WeeklyReport $report): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new WeeklyReportResource($report),
        ]);
    }

    /**
     * Mise à jour d'un rapport.
     */
    public function update(
        UpdateWeeklyReportRequest $request,
        WeeklyReport $report
    ): JsonResponse {

        $report->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Rapport mis à jour.',
            'data' => new WeeklyReportResource($report),
        ]);
    }

    /**
     * Suppression d'un rapport.
     */
    public function destroy(
        WeeklyReport $report
    ): JsonResponse {

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rapport supprimé.',
        ]);
    }
}
