<?php
namespace App\Http\Services;

use App\Enum\ServiceEnum;
use App\Models\CityWeather;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;

class CityWeatherService implements WeatherServiceInterface
{
    private const API_ACCESS_KEY = '2806343d9a809aacb3dc63acfff12cba';

    /**
     * Returns weather information for a passed city
     *
     * @param string $city_name
     * @return \App\Http\Controllers
     */
    public function getCityWInfo($city_name)
    {
        /**
         *
         * @var Collection $city_data
         *
         */
        $city_data = CityWeather::where('city', '=', $city_name)
            ->where('service', '=', ServiceEnum::WEATHER_STACK)
            ->get();
        $count = $city_data->count();
        if ($count > 0) {
            $city = $city_data[0];
            $is_in_same_hour = $this->inSameHour($city->updated_at);
            if (! $is_in_same_hour) {
                $city = $this->getAndSaveWatherInfo($city_name, $city);
            }
        } else {
            $city = $this->getAndSaveWatherInfo($city_name);
        }
        return json_decode($city);
    }

    /**
     * Returns true if the last checked time is the same time as the current time
     *
     * @param string $last_checked
     * @return number
     */
    private function inSameHour($last_checked)
    {
        $last_date = new \DateTime($last_checked);
        $current_hour = date('H', time());
        $last_hour = $last_date->format('H');
        return $current_hour == $last_hour;
    }

    /**
     * Returns and save city weather inforamtion from weather stack API
     *
     * @param string $city_name
     * @param \App\Models\CityWeather $city
     * @return \App\Models\CityWeather
     */
     private function getAndSaveWatherInfo($city_name, $city = null)
    {
        $contents = self::getWeatherStackInfo($city_name);

        if (!isset($contents->error)) {
            $data = [
                'city' => $city_name,
                'service' => ServiceEnum::WEATHER_STACK,
                'weather_info' => $contents->current->temperature,
            ];
            if (!$city) {
                $city = CityWeather::create($data);
            } else {
                $city['weather_info'] = $data['weather_info'];
            }
            $city->save();
        } else {
            $city = json_encode($contents->error);
        }
        return $city;
    }

    /**
     * Returns city weather inforamtion from weather stack API
     *
     * @param string $city_name
     * @return string
     */
    private function getWeatherStackInfo($city_name)
    {
        $key = self::API_ACCESS_KEY;
        $url = "http://api.weatherstack.com/current?access_key=$key&query=$city_name";
        $response = Http::accept('application/json')->get($url);
        return json_decode($response->getBody()->getContents());
    }
}
