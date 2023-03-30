<?php
namespace App\Http\Resources;

use App\Http\Services\CityWeatherManager;
use Illuminate\Http\Resources\Json\JsonResource;

class CityWeatherResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

}
