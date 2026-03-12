<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(): JsonResponse 
    {
        $stats = $this->dashboardService->getGlobalStats();

        return response()->json([
            'success' => true,
            'message' => 'Statistiques récupérées avec succès',
            'data' => $stats
        ]);
    }
}