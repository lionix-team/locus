<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class Repository
{
    public $model;

    public function __construct($model)
    {
        /** @var \Eloquent $model */
        $this->model = $model;
    }

    /**
     * Get records
     *
     * @param bool $page
     * @param bool $orderDesc
     * @return \Eloquent|\Eloquent[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all($page = false, $orderDesc = false)
    {
        $records = $this->model;
        if ($orderDesc) {
            $records = $records->orderBy('id', 'desc');
        }
        if ($page) {
            $records = $records->paginate(20);
        } else {
            $records = $records->get();
        }
        return $records;
    }

    /**
     * Get record by id
     *
     * @param $id
     * @return \Eloquent|\Eloquent[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create new record
     *
     * @param $data
     * @return Model
     */
    public function create($data)
    {
        /** @var Model $model */
        $this->model = new $this->model;
        $this->model->fill($data);
        $this->model->save();
        return $this->model;
    }

    /**
     * Edit record by record instance
     *
     * @param Model $model
     * @param $data
     * @return Model
     */
    public function edit(Model $model, $data)
    {
        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * Delete record by model instance
     *
     * @param Model $model
     * @return bool|null
     */
    public function delete(Model $model)
    {
        try {
            $deleted = $model->delete();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return $deleted;
    }
}
