<?php

namespace App\Services;

use App\Models\Place;
use App\Repositories\PlaceRepository;

class PlaceService extends ApiService
{
    /**
     * Get google map places by type
     *
     * @param $type
     * @param null $pageToken
     * @return mixed
     */
    public static function getByType($type, $pageToken = null)
    {
        $url = 'nearbysearch/json?location=40.1863078,44.4721365&rankby=distance&type=' .
            $type . '&key=' . (new self)->key;
        if ($pageToken) {
            $url .= '&pagetoken=' . $pageToken;
        }
        $req = (new self)->client->get($url);
        return json_decode($req->getBody(), 1);
    }

    /**
     * Synchronize google map places with our places
     *
     * @param null $pageToken
     */
    public static function synchronize($pageToken = null)
    {
        $types = Place::getTypes();
        $placeIds = [];
        $repository = new PlaceRepository();
        foreach ($types as $key => $type) {
            $places = PlaceService::getByType($key, $pageToken);
            foreach ($places['results'] as $place) {
                $placeInfo = [
                    'name' => $place['name'],
                    'place_id' => $place['id'],
                    'type' => $type,
                    'latitude' => $place['geometry']['location']['lat'],
                    'longitude' => $place['geometry']['location']['lng'],
                    'street' => $place['vicinity']
                ];
                if (!$repository->getByPlaceId($placeInfo['place_id'])) {
                    $repository->create($placeInfo);
                }
                $placeIds[$placeInfo['place_id']] = $placeInfo['place_id'];
            }
            if (isset($places['next_page_token'])) {
                self::synchronize($places['next_page_token']);
            }
        }
    }

    /**
     * Calculate distance between two coordinates
     *
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @return float
     */
    public static function getDistanceBetweenTwoCoords($lat1, $lon1, $lat2, $lon2)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }
}
