<?php

namespace App\Http\Resources;

use App\Models\Place;
use App\Services\PlaceService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResourceForFuelSort extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Place $place */
        $place = $this;
        return [
            'id' => $place->id,
            'name' => $place->name,
            'latitude' => $place->latitude,
            'longitude' => $place->longitude,
            'street' => $place->street,
            'photo' => $place->photo,
            'photoPath' => $place->photo ? asset('/storage/places/' . $place->photo) : null,
            'open_at' => $place->open_at ? Carbon::parse($place->open_at)->format('H:i') : '',
            'close_at' => $place->close_at ? Carbon::parse($place->close_at)->format('H:i') : '',
            'far' =>($request['lat'] && $request['lng']) ?PlaceService::getDistanceBetweenTwoCoords($request['lat'], $request['lng'],
                $place->latitude, $place->longitude) : false,
        ];
    }
}
