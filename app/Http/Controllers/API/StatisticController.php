<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StatisticResource;
use App\Http\Services\StatisticService;
use Illuminate\Http\Request;

class StatisticController extends BaseController
{
    private StatisticService $statisticService;

    public function __construct(
        StatisticService $statisticService
) {
    $this->statisticService = $statisticService;
}
    /**
     *
     * @param Request $request
     * @param string $time
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatistic(Request $request, $time)
    {
        $data = $this->statisticService->getStatistics($time);
        return response()->json($data);
    }

}
