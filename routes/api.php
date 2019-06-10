<?php

Route::apiResource('/ad', 'AdController');
Route::apiResource('/category', 'CategoryController');
Route::apiResource('/ad/{ad}/message', 'MessageController');

Route::post('/like/{message}', 'LikeController@LikeIt');
Route::delete('/like/{message}', 'LikeController@UnLikeIt');

Route::post('notifications', 'NotificationController@index');
Route::post('markAsRead', 'NotificationController@markAsRead');

Route::apiResource('/upload', 'UploadController');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('facebooklogin', 'AuthfacebookController@login');

});
