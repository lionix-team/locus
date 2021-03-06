<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StatusCodeHelper;
use App\Http\Resources\Place\PlaceResource;
use App\Models\Place;
use App\Repositories\PlaceRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class PlaceController extends Controller
{
    private $statusCode;
    private $success;
    private $data;
    private $errors;
    private $repository;

    public function __construct(PlaceRepository $repository)
    {
        $this->statusCode = StatusCodeHelper::HTTP_BAD_REQUEST;
        $this->success = false;
        $this->data = [];
        $this->errors = [];
        $this->repository = $repository;
    }

    /**
     * Get places
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $fuelTypes = $request->get('fuel_types') ? explode(',', $request->get('fuel_types')) : [];
        $places = $this->repository->filter(false, 0, true, $request->get('keyword'),
            $fuelTypes);
        $this->data['places'] = PlaceResource::collection($places);
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        $this->success = true;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }

    /**
     * Get place
     *
     * @param Place $place
     * @return mixed
     */
    public function get(Place $place)
    {
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        $this->data['place'] = new PlaceResource($place);
        $this->success = true;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
