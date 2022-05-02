<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api'], 'prefix' => 'v1/coffee', 'namespace' => '\Src\Components\Coffee\Infrastructure\Api'], function () {
    Route::post('/espresso', ['uses' => 'CoffeeController@setEspresso']);
    Route::post('/double-espresso', ['uses' => 'CoffeeController@setDoubleEspresso']);
    Route::get('/status', ['uses' => 'CoffeeController@getStatus']);
  
});


