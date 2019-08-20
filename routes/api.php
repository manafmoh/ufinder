<?php

Route::apiResource('/ad', 'AdController');
Route::apiResource('/ad/{cat}/category', 'AdController');
Route::apiResource('/ad/{cat}/{subcat}/subcategory', 'AdController');
Route::apiResource('/category', 'CategoryController');
Route::apiResource('/category/{category}/subcategory', 'SubcategoryController');
Route::apiResource('/ad/{ad}/message', 'MessageController');

Route::post('/like/{message}', 'LikeController@LikeIt');
Route::delete('/like/{message}', 'LikeController@UnLikeIt');

Route::post('notifications', 'NotificationController@index');
Route::post('markAsRead', 'NotificationController@markAsRead');

Route::apiResource('/upload', 'UploadController');

Route::get('/search', 'SubcategoryController@search');
Route::get('/ad/search/{search}', 'AdController@search');

Route::apiResource('/state', 'StateController');
Route::apiResource('/state/{state}/district', 'DistrictController');
Route::apiResource('/state/{state}/{district}/place', 'PlaceController');

Route::get('/places', 'PlaceController@search');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    //Route::post('facebooklogin', 'AuthfacebookController@login');
    Route::post('facebooklogin', 'AuthgoogleController@login');

});
