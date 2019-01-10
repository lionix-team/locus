<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StatusCodeHelper;
use App\Http\Requests\Place\CreateRequest;
use App\Models\Place;
use App\Repositories\PlaceRepository;
use App\Http\Controllers\Controller;
use Storage;

class PlaceController extends Controller
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
        $this->repository = new PlaceRepository();
    }

    /**
     * Create
     *
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $data = $request->except(['fuel_types']);
        $image = $request->input('photo');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(60) . '.' . 'png';
        Storage::disk('places')->put($imageName, $image);
        $data['type'] = Place::getTypes()[Place::TYPE_GAS_STATION];
        $data['photo'] = $imageName;
        /** @var Place $place */
        $place = $this->repository->create($data);
        if ($place) {
            foreach ($request->input('fuel_types') as $key => $fuelType) {
                if (isset($fuelType['price'])) {
                    $place->fuelTypes()->create(['fuel_type_id' => $fuelType['id'], 'price' => $fuelType['price']]);
                }
            }
        }
    }
}
