<?php

namespace App\Http\Controllers\Api;

use App\Repositories\PlaceRepository;
use App\Services\PlaceService;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    private $repository;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->repository = $placeRepository;
    }

    public function index()
    {
        PlaceService::synchronize();
    }
}
