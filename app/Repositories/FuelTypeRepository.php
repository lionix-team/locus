<?php

namespace App\Repositories;

use App\Models\FuelType;

class FuelTypeRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new FuelType());
    }
}
