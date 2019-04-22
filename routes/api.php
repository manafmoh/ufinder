<?php

Route::apiResource('/ad', 'AdController');
Route::apiResource('/category', 'CategoryController');
Route::apiResource('/ad/{ad}/message', 'MessageController');
