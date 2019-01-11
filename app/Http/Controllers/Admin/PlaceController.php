<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StatusCodeHelper;
use App\Http\Requests\Place\CreateRequest;
use App\Http\Requests\Place\EditRequest;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Models\PlaceFuelType;
use App\Repositories\PlaceFuelTypeRepository;
use App\Repositories\PlaceRepository;
use App\Http\Controllers\Controller;
use Response;
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
        $base64_str = substr($image, strpos($image, ",") + 1);
        $image = base64_decode($base64_str);
        $imageName = str_random(60) . '.' . 'png';
        Storage::disk('places')->put($imageName, $image);
        $data['type'] = Place::getTypes()[Place::TYPE_GAS_STATION];
        $data['photo'] = $imageName;
        /** @var Place $model */
        $model = $this->repository->create($data);
        $placeFuelTypeRepository = new PlaceFuelTypeRepository();
        if ($model) {
            foreach ($request->input('fuel_types') as $key => $fuelType) {
                if (isset($fuelType['price'])) {
                    $data = [
                        'place_id' => $model->id,
                        'fuel_type_id' => $fuelType['id'],
                        'price' => $fuelType['price']
                    ];
                    $placeFuelTypeRepository->create($data);
                }
            }
            $this->success = true;
            $this->statusCode = StatusCodeHelper::HTTP_CREATED;
        }
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }

    public function edit(EditRequest $request, Place $place)
    {
        $data = $request->except(['fuel_types']);
        $imageName = $place->photo;
        if (!empty($request->input('photo'))) {
            Storage::disk('places')->delete($place->photo);
            $image = $request->input('photo');
            $base64_str = substr($image, strpos($image, ",") + 1);
            $image = base64_decode($base64_str);
            $imageName = str_random(60) . '.' . 'png';
            Storage::disk('places')->put($imageName, $image);
        }
        $data['photo'] = $imageName;
        $data['type'] = Place::getTypes()[Place::TYPE_GAS_STATION];
        /** @var Place $model */
        $model = $this->repository->edit($place, $data);
        $placeFuelTypeRepository = new PlaceFuelTypeRepository();
        if ($model) {
            $fuelTypeIds = [];
            foreach ($request->input('fuel_types') as $key => $fuelType) {
                $placeFuelType = $placeFuelTypeRepository->getByPlaceIdAndFuelTypeId($model->id, $fuelType['id']);
                if (isset($fuelType['price']) && !empty($fuelType['price'])) {
                    $data = [
                        'place_id' => $model->id,
                        'fuel_type_id' => $fuelType['id'],
                        'price' => $fuelType['price']
                    ];
                    /** @var PlaceFuelType $fuelType */
                    if ($placeFuelType) {
                        $fuelType = $placeFuelTypeRepository->edit($placeFuelType, $data);
                    } else {
                        $fuelType = $placeFuelTypeRepository->create($data);
                    }
                }
                $fuelTypeIds[$fuelType['id']] = $fuelType['id'];
                if ($fuelTypeIds) {
                    $placeFuelTypeRepository->deleteByPlaceIdAndExceptIds($model->id, $fuelTypeIds);
                }
            }
            $this->success = true;
            $this->statusCode = StatusCodeHelper::HTTP_OK;
            $this->data['place'] = new PlaceResource($model);
        }
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
