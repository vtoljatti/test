<?php

namespace App\Http\Resources;

use App\CityStreets;
use Illuminate\Http\Resources\Json\JsonResource;

class CityStreetsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city_id' => $this->city_id,
            'is_hidden' => $this->is_hidden,
        ];
    }
}
