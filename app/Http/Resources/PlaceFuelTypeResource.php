<?php

namespace App\Http\Resources;

use App\Models\PlaceFuelType;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceFuelTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var PlaceFuelType $fuelType */
        $fuelType = $this;
        return [
            'price' => $fuelType->price,
            'gas_station' => new PlaceResourceForFuelSort($fuelType->gas_station)
        ];
    }
}
