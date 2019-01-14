<?php
Route::get('/', 'IndexController');
Route::prefix('/auth')->group(function () {
    Route::post('login', 'AuthController@login');
});
Route::middleware('auth:api')->group(function () {
    Route::prefix('places')->group(function () {
        Route::get('/', 'PlaceController@index');
        Route::post('/', 'PlaceController@create');
        Route::put('{place}', 'PlaceController@edit');
        Route::delete('{place}', 'PlaceController@delete');
    });
});
