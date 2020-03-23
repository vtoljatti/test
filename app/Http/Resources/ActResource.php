<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActResource extends JsonResource
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
            'date' => $this->date,
            'time' => $this->time,
            'number_sales_1' => $this->number_sales_1,
            'number_sales_2' => $this->number_sales_2,
            'number_sales_3' => $this->number_sales_3,
            'city' => $this->city,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'cost' => $this->cost,
            'is_to_bring' => $this->is_to_bring,
            'is_exchange' => $this->is_exchange,
            'street' => $this->street,
            'home' => $this->home,
            'apartment' => $this->apartment,
            'porch' => $this->porch,
            'last_name' => $this->last_name,
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'phone_3' => $this->phone_3,
            'is_dialing' => $this->is_dialing,
            'time_dialing' => $this->time_dialing,
            'is_lift_up' => $this->is_lift_up,
            'is_questionable' => $this->is_questionable,
            'is_elevator' => $this->is_elevator,
            'comment' => $this->comment,
            'floor' => $this->floor,
            'seller_id' => $this->seller_id,
            'driver_id' => $this->driver_id,
            'user_id' => $this->user_id,
            'user_city_id' => $this->user_city_id,
            'is_hidden' => $this->is_hidden,
            'created_at' => now()->parse($this->created_at)->format('d.m.Yг. H:i'),
        ];
    }
}
