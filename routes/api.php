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

//    Route::group(['namespace' => 'Api'], function () {
//        Route::group(['namespace' => 'Auth'], function () {
//            Route::post('register', 'RegisterController');
//            Route::post('login', 'LoginController');
//            Route::post('logout', 'LogoutController')->middleware('auth:api');
//        });
//    });

    Route::group(['prefix'=>'cities'], function () {
        Route::get('/', 'CitiesController@index');
        Route::post('/store', 'CitiesController@store');
        Route::post('/update', 'CitiesController@update');
        Route::get('/{id}', 'CitiesController@city');
        Route::get('/{id}/districts', 'CitiesController@districtsCity');
        Route::get('/{id}/streets', 'CitiesController@streetsCity');
        Route::get('/{id}/villages', 'CitiesController@villagesCity');
        Route::get('/{id}/{district_id}', 'CitiesController@districtCity');
    });

    Route::group(['prefix'=>'districts'], function () {
        Route::get('/', 'DistrictsController@index');
        Route::post('/store', 'DistrictsController@store');
        Route::post('/update', 'DistrictsController@update');
        Route::get('/{id}', 'DistrictsController@district');
        Route::get('/{id}/street', 'CitiesController@dstreetCity');
    });

    Route::group(['prefix'=>'streets'], function () {
        Route::get('/', 'StreetsController@index');
        Route::post('/store', 'StreetsController@store');
        Route::post('/update', 'StreetsController@update');
        Route::get('/{id}', 'StreetsController@street');
    });

    Route::group(['prefix'=>'villages'], function () {
        Route::get('/', 'VillagesController@index');
        Route::post('/store', 'VillagesController@store');
        Route::post('/update', 'VillagesController@update');
        Route::get('/{id}', 'VillagesController@village');
    });

    Route::group(['prefix'=>'users'], function () {
        Route::get('/', 'UsersController@index');
        Route::get('/auth', 'UsersController@auth');
        Route::get('/logout', 'UsersController@logout');
        Route::post('/store', 'UsersController@store');
        Route::post('/update', 'UsersController@update');
        Route::get('/{id}', 'UsersController@user');
    });

    Route::group(['prefix'=>'roles'], function () {
        Route::get('/', 'RolesController@index');
    });

    Route::group(['prefix'=>'sellers'], function () {
        Route::get('/', 'SellersController@index');
        Route::post('/store', 'SellersController@store');
        Route::post('/update', 'SellersController@update');
        Route::get('/{id}', 'SellersController@seller');
    });

});
