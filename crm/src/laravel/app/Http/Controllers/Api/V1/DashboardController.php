<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GetDashboardRequest;
use App\Http\Resources\Dashboard\DashboardResource;
use App\Services\Dashboard\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct( DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(GetDashboardRequest $request)
    {
        $data = $this->dashboardService->getDashboard($request);

        return response()->json([
            'data' => new DashboardResource($data),
        ], 200);

    }
}
