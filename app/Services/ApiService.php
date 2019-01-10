<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiService
{
    protected $client;
    protected $key;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.google_map.base_uri')
        ]);
        $this->key = config('services.google_map.key');
    }
}
