<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StatusCodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\CreateRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Place;
use Response;

class ReviewController extends Controller
{
    private $statusCode;
    private $success;
    private $data;
    private $errors;

    public function __construct()
    {
        $this->statusCode = StatusCodeHelper::HTTP_BAD_REQUEST;
        $this->success = false;
        $this->data = [];
        $this->errors = [];
    }

    /**
     * Add review for place
     *
     * @param CreateRequest $request
     * @param Place $place
     * @return mixed
     */
    public function create(CreateRequest $request, Place $place)
    {
        $model = $place->reviews()->create($request->all());
        if ($model) {
            $this->statusCode = StatusCodeHelper::HTTP_CREATED;
            $this->success = true;
            $this->data['review'] = new ReviewResource($model);
        }
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
