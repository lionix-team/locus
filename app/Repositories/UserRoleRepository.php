<?php

namespace App\Repositories;

use App\Models\UserRole;

class UserRoleRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new UserRole());
    }

    /**
     * Get role by name
     *
     * @param $name
     * @return \Eloquent|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByName($name)
    {
        return $this->model->where(['name' => $name])->first();
    }
}
