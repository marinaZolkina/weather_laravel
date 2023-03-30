<?php
namespace App\Http\Controllers\API;

use App\Http\Services\StatisticService;
use App\Http\Services\WeatherService;
use Illuminate\Http\Request;

class CityWeatherController extends BaseController
{
    private WeatherService $weatherService;
    private StatisticService $statisticService;

    public function __construct(
        WeatherService $weatherService,
        StatisticService $statisticService
    ) {
        $this->weatherService = $weatherService;
        $this->statisticService = $statisticService;
    }
    /**
     *
     * @param Request $request
     * @param string $cityName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCityWInfo(Request $request, $cityName)
    {
        $data = $this->weatherService->updateInformationOnAllServices($cityName);
        $this->statisticService->saveStatic();
        return response()->json($data);
    }

}
