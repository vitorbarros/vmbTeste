<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//root route
Route::get('/', function () {
   return redirect()->route('app.sintegra.index');
});

//Authenticate route
Route::get('/login', array('as' => 'login', 'uses' => 'Auth\AuthController@getLogin'));
Route::post('/login', array('as' => 'login.post', 'uses' => 'Auth\AuthController@postLogin'));

//Internal system routes
Route::group(array('prefix' => 'app', 'middleware' => 'auth.checkauth', 'as' => 'app.'), function () {
    Route::group(array('prefix' => 'sintegra', 'as' => 'sintegra.'), function () {
        Route::get('/', array('as' => 'index', 'uses' => 'SintegraController@index'));
        Route::get('/consulta', array('as' => 'consulta', 'uses' => 'SintegraController@consulta'));
        Route::post('/store', array('as' => 'store', 'uses' => 'SintegraController@store'));
        Route::post('/sintegra-request', array('as' => 'sintegrarequest', 'uses' => 'SintegraController@sintegraRequest'));
    });
});