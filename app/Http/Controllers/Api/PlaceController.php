<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use App\Repositories\PlaceRepository;
use App\Services\PlaceService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    private $repository;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->repository = $placeRepository;
    }

    public function index(Request $request)
    {
        PlaceService::synchronize();
    }
}
