<?php

namespace App\Repositories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Model;

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
     * Get places
     *
     * @param int $page
     * @param int $limit
     * @param bool $orderDesc
     * @param string $keyword
     * @return \Eloquent|\Eloquent[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getPlaces($page = 0, $limit = 20, $orderDesc = false, $keyword = "")
    {
        $records = $this->model;
        if ($keyword) {
            $records = $records->where(function ($query) use ($keyword) {
                /** @var \Eloquent $query */
                $query->where('name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
            });
        }
        if ($orderDesc) {
            $records = $records->orderBy('id', 'desc');
        }
        if ($page) {
            $records = $records->paginate($limit);
        } else {
            $records = $records->get();
        }
        return $records;
    }
}
