<?php

namespace App\Http\Resources;

use App\Streets;
use Illuminate\Http\Resources\Json\JsonResource;

class StreetsResource extends JsonResource
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
            'district_id' => $this->district_id,
            'is_hidden' => $this->is_hidden,
        ];
    }
}
