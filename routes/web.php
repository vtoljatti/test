<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('index');

//Route::group(['prefix'=>'city'], function () {
//    Route::get('/', 'CitiesController@index')->name('city.index');
//    Route::post('store', 'CitiesController@store')->name('city.store');
//    Route::post('update', 'CitiesController@update')->name('city.update');
//});





