<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/', 'HomeController@index');
Route::middleware('auth:api')->group(function () {

    Route::group(['prefix'=>'cities'], function () {
        Route::get('/', 'CitiesController@index');
        Route::get('/{city_id}', 'CitiesController@show');
        Route::get('/{city_id}/districts', 'CitiesController@districtsCity');
        Route::get('/{city_id}/streets', 'CitiesController@streetsCity');
        Route::get('/{city_id}/{district_id}', 'CitiesController@streetsDistrictCity');
    });

    Route::group(['prefix'=>'villages'], function () {
        Route::get('/', 'VillagesController@index');
    });

    Route::group(['prefix'=>'users'], function () {
        Route::get('/', 'UsersController@index');
        Route::post('/store', 'UsersController@store');
        Route::post('/update', 'UsersController@update');
        Route::get('/{id}', 'UsersController@user');
    });

    Route::group(['prefix'=>'roles'], function () {
        Route::get('/', 'RolesController@index');
    });

    Route::group(['prefix'=>'sellers'], function () {
        Route::get('/', 'SellersController@index');
    });

});
