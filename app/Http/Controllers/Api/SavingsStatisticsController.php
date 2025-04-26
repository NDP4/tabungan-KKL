<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChartDataService;
use App\Services\SavingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SavingsStatisticsController extends Controller
{
    public function __construct(
        private ChartDataService $chartDataService,
        private SavingsService $savingsService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        return response()->json([
            'chart_data' => $this->chartDataService->getSavingsChartData($userId),
            'weekly_data' => $this->chartDataService->getWeeklySavingsData($userId),
            'progress' => $this->savingsService->getProgressSummary($request->user()),
        ]);
    }

    public function classProgress(): JsonResponse
    {
        return response()->json([
            'progress_data' => $this->chartDataService->getProgressByStudent(),
        ]);
    }
}
