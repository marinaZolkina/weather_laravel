<?php

namespace App\Http\Services;
use App\Models\CityWeather;
use Illuminate\Support\Facades\DB;

class WeatherService
{
    public function updateInformationOnAllServices($cityName) {
        $data = [];
        $result = null;
        $weatherStack = new CityWeatherService();
        $checkWeatherStack  = $this->checkApi($weatherStack->getCityWInfo($cityName));
        $data['weatherStack'] = $checkWeatherStack;

        $tomorrow = new TomorrowService();
        $checkTomorrow = $this->checkApi($tomorrow->getCityWInfo($cityName));
        $data['tomorrow'] = $checkTomorrow;

        if($checkWeatherStack['status'] == 200 && $checkTomorrow['status'] == 200) {
            $result = $this->getAverageValueOnAllServices($cityName);
            $data['avg'] = $result;
        }

        return $data;
    }

    private function getAverageValueOnAllServices($cityName) {
        return DB::select('SELECT AVG(weather_info) FROM city_weather WHERE city = :city', ['city' => $cityName]);
    }

    private function checkApi($city) {
        if (isset($city->weather_info)) {
            $weatherInfo = json_decode($city->weather_info);
            $status = 200;
        } else {
            $status = 404;
            $weatherInfo = $city;
        }
        $data = [
            'weatherInfo' => $weatherInfo,
            'status' => $status
        ];
        return $data;
    }
}
