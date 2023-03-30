<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatisticTomorrow extends Model
{
    use HasFactory;

    protected $table = 'statistic_tomorrow';
    protected $fillable = [
        'request',
        'date',
        'created_at',
        'updated_at'
    ];
}
