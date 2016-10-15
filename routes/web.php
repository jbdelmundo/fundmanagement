<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'DashboardController@index');


Route::get('/balance', 'DashboardController@balance');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/collection', 'CollectionController@index');
Route::post('/collection', 'CollectionController@store');
Route::get('/collection/{aysem}', 'CollectionController@show');

Route::get('/requests', 'RequestsController@index');

Route::get('/requests/{dept}/{aysem}', 'RequestsController@show');
Route::post('/requests/{dept}/{aysem}', 'RequestsController@create');