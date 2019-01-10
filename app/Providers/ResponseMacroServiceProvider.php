<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($success, $data, $errors, $statusCode) {
            return Response::json([
                'success' => $success,
                'data' => $data,
                'errors' => $errors,
            ], $statusCode);
        });
    }
}
