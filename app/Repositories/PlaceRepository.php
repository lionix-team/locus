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

    /**
     * Filter places
     *
     * @param bool $pagination
     * @param int $limit
     * @param bool $orderDesc
     * @param string $keyword
     * @param array $fuelTypes
     * @return \Eloquent|\Eloquent[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\
     * Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function filter($pagination = false, $limit = 20, $orderDesc = false, $keyword = "", $fuelTypes = [])
    {
        $records = $this->model;
        if ($fuelTypes) {
            $records = $records->whereHas('fuel_types', function ($query) use ($fuelTypes) {
                /** @var \Eloquent $query */
                $query->whereIn('fuel_type_id', $fuelTypes);
            });
        }
        if ($keyword) {
            $records = $records->where(function ($query) use ($keyword) {
                /** @var \Eloquent $query */
                $query->where('name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('street', 'LIKE', '%' . $keyword . '%');
            });
        }
        if ($orderDesc) {
            $records = $records->orderBy('id', 'desc');
        }
        if ($pagination) {
            $records = $records->paginate($limit);
        } else {
            $records = $records->get();
        }
        return $records;
    }
}
