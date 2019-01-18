<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new Review());
    }

    /**
     * Filter reviews
     *
     * @param bool $pagination
     * @param int $limit
     * @param bool $orderDesc
     * @param string $keyword
     * @param string $status
     * @param bool $withPlace
     * @return \Eloquent|\Eloquent[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\
     * Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function filter($pagination = false, $limit = 20, $orderDesc = false, $keyword = "", $status = "",
                           $withPlace = true)
    {
        $records = $this->model;
        if ($keyword) {
            $records = $records->where(function ($query) use ($keyword) {
                /** @var \Eloquent $query */
                $query->where('text', 'LIKE', '%' . $keyword . '%');
                $query->orWhereHas('place', function ($query) use ($keyword) {
                    /** @var \Eloquent $query */
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                    $query->orWhere('street', 'LIKE', '%' . $keyword . '%');
                });
            });
        }
        if ($status !== null) {
            $records = $records->where(['status' => $status]);
        }
        if ($withPlace) {
            $records = $records->with(['place']);
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

    /**
     * Change status
     *
     * @param $status
     * @param Review $model
     * @return Review
     */
    public function changeStatus($status, Review $model)
    {
        $model->status = $status;
        $model->save();
        return $model;
    }
}
