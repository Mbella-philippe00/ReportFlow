<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboard,
    ) {}

    /**
     * Dashboard principal.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new DashboardResource(
                $this->dashboard->getDashboardData()
            ),
        ]);
    }
}
