<?php

namespace App\Repositories;

use App\Models\Place;

class PlaceRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new Place());
    }

    /**
     * Get place by place_id
     *
     * @param $placeId
     * @return \Eloquent|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByPlaceId($placeId)
    {
        return $this->model->where(['place_id' => $placeId])->first();
    }
}
