<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityWeather extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'service',
        'weather_info',
        'updated_at'
    ];
}
