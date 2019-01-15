<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('places')->group(function () {
    Route::any('/', 'PlaceController@index');
    Route::get('/{place}', 'PlaceController@get');
    Route::post('/{place}/review', 'ReviewController@create');
});
Route::get('/fuel-types', 'FuelTypeController@index');
Route::get('/fuel-types/{fuelType}', 'FuelTypeController@sort');
