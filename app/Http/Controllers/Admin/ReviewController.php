<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StatusCodeHelper;
use App\Models\Review;
use App\Repositories\ReviewRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class ReviewController extends Controller
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
        $this->repository = new ReviewRepository();
    }

    /**
     * Get reviews list
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $reviews = $this->repository->filter(true, 1, true, $request->get('keyword'),
            $request->get('status'));
        $this->data['reviews'] = $reviews;
        $this->statusCode = StatusCodeHelper::HTTP_OK;
        $this->success = true;
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }

    /**
     * Change review status
     *
     * @param $status
     * @param Review $review
     * @return mixed
     */
    public function changeStatus($status, Review $review)
    {
        if ($status != Review::STATUS_DECLINED && $status != Review::STATUS_APPROVED) {
            $status = $review->status;
        }
        $model = $this->repository->changeStatus($status, $review);
        if ($model) {
            $this->data['review'] = $model->fresh(['place']);
            $this->statusCode = StatusCodeHelper::HTTP_OK;
            $this->success = true;
        }
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
