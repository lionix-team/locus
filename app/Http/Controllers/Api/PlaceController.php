<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StatusCodeHelper;
use App\Http\Resources\PlaceResource;
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

    public function index(Request $request)
    {
        $places = $this->repository->getPlaces($request->get('page'), 20, true, $request->get('keyword'));
        $this->data['places'] = $places;
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
    public function show(Place $place)
    {
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        $this->data['place'] = new PlaceResource($place);
        $this->success = true;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
