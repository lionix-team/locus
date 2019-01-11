<?php

use Illuminate\Http\Request;

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
    Route::get('/', 'PlaceController@index');
    Route::get('/{place}', 'PlaceController@show');
});
Route::get('/fuel-types', 'FuelTypeController');
