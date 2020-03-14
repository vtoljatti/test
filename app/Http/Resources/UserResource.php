<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'role' => $this->role,
            'short_name' => $this->short_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'seller_id' => $this->seller_id,
            'is_hidden' => $this->is_hidden,
        ];
    }
}
