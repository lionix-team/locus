<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StatusCodeHelper;
use App\Http\Resources\FuelTypeResource;
use App\Http\Resources\PlaceFuelTypeResource;
use App\Models\FuelType;
use App\Models\PlaceFuelType;
use App\Repositories\FuelTypeRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PlaceFuelTypeRepository;
use Response;

class FuelTypeController extends Controller
{
    private $statusCode;
    private $success;
    private $data;
    private $errors;
    private $repository;
    private $placeFuelTypeRepository;

    public function __construct()
    {
        $this->statusCode = StatusCodeHelper::HTTP_BAD_REQUEST;
        $this->success = false;
        $this->data = [];
        $this->errors = [];
        $this->repository = new FuelTypeRepository();
        $this->placeFuelTypeRepository = new PlaceFuelTypeRepository();
    }

    /**
     * Get all fuel types
     *
     * @return mixed
     */
    public function index()
    {
        $this->data['fuel_types'] = $this->repository->all();
        $this->success = true;
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }

    /**
     * Sort gas stations fuel types
     *
     * @param FuelType $fuelType
     * @return mixed
     */
    public function sort(FuelType $fuelType)
    {
        $this->data['fuel_type'] = new FuelTypeResource($fuelType);
        $this->data['stations'] = PlaceFuelTypeResource::collection($this->placeFuelTypeRepository
            ->sortByPrice($fuelType->id));
        $this->success = true;
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
