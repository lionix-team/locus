<?php

namespace App\Repositories;

use App\Models\PlaceFuelType;

class PlaceFuelTypeRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new PlaceFuelType());
    }

    /**
     * Get fuel type info by place_id and fuel_type_id column
     *
     * @param $placeId
     * @param $fuelTypeId
     * @return \Eloquent|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByPlaceIdAndFuelTypeId($placeId, $fuelTypeId)
    {
        return $this->model->where(['place_id' => $placeId, 'fuel_type_id' => $fuelTypeId])->first();
    }

    /**
     * Sort gas stations fuel types by price
     *
     * @param $fuelTypeId
     * @return \Eloquent[]|\Illuminate\Database\Eloquent\Collection
     */
    public function sortByPrice($fuelTypeId)
    {
        return $this->model->where(['fuel_type_id' => $fuelTypeId])->orderBy('id', 'asc')->get();
    }

    /**
     * Delete records by place id and except ids
     *
     * @param $placeId
     * @param $exceptIds
     * @return bool|int|null
     */
    public function deleteByPlaceIdAndExceptIds($placeId, $exceptIds)
    {
        $records = $this->model->where(['place_id' => $placeId])->whereNotIn('id', $exceptIds);
        try {
            $deleted = $records->delete();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return $deleted;
    }
}
