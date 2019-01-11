<?php
Route::get('/', 'IndexController');
Route::prefix('/auth')->group(function () {
    Route::post('login', 'AuthController@login');
});
Route::prefix('places')->group(function () {
    Route::post('/', 'PlaceController@create');
    Route::put('{place}', 'PlaceController@edit');
});
