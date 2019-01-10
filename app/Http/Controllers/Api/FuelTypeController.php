<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StatusCodeHelper;
use App\Repositories\FuelTypeRepository;
use App\Http\Controllers\Controller;
use Response;

class FuelTypeController extends Controller
{
    private $statusCode;
    private $success;
    private $data;
    private $errors;
    private $repository;

    public function __construct()
    {
        $this->statusCode = StatusCodeHelper::HTTP_BAD_REQUEST;
        $this->success = false;
        $this->data = [];
        $this->errors = [];
        $this->repository = new FuelTypeRepository();
    }

    /**
     * Get all fuel types
     *
     * @return mixed
     */
    public function __invoke()
    {
        $this->data['fuel_types'] = $this->repository->all();
        $this->success = true;
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
