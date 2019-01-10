<?php
Route::get('/', 'IndexController');
Route::prefix('/auth')->group(function () {
    Route::post('login', 'AuthController@login');
});
Route::post('/places', 'PlaceController@create');
