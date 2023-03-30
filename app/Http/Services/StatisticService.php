<?php

namespace App\Http\Services;

use App\Models\StatisticTomorrow;
use Illuminate\Support\Facades\DB;

class StatisticService
{

    public function getStatistics($time) {
        $result = null;
        if($time && ($time == 'day' || $time == 'month')) {
            if($time == 'day') {
                $result = $this->getStatFromDay();
            } else {
                $result = $this->getStatFromMonth();
            }
        }
        return $result;
    }

    private function getStatFromDay() {
        return DB::select('SELECT * FROM statistic_tomorrow WHERE date = CURDATE()');
    }

    private function getStatFromMonth() {
        return DB::select('SELECT * from statistic_tomorrow WHERE YEAR(`date`) = YEAR(NOW()) AND MONTH(`date`) = MONTH(NOW())');
    }

    public function saveStatic() {
        $data = [
            'date' => date('Y-m-d'),
            'request' => 'https://api.tomorrow.io/v4/weather/realtime'
        ];
        $stat = StatisticTomorrow::create($data);
        $stat->save();
    }
}
