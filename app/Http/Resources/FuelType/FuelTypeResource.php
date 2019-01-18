<?php

namespace App\Http\Resources\FuelType;

use App\Models\FuelType;
use Illuminate\Http\Resources\Json\JsonResource;

class FuelTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var FuelType $fuelType */
        $fuelType = $this;
        return [
            'id' => $fuelType->id,
            'name' => $fuelType->name
        ];
    }
}
