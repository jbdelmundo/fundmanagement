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
Route::post('/requests', 'RequestsController@create');

Route::get('/endorsement', 'RequestEndorsementController@index');
Route::post('/endorsement', 'RequestEndorsementController@create');

Route::get('/semestermanagement', 'SemesterManagementController@index');
Route::post('/semestermanagement', 'SemesterManagementController@create');

Route::get('/endorsement/remove/{request_id}', 'RequestEndorsementController@remove');

Route::get('/switch_active_dept/{id}','SessionController@switch_active_dept');
Route::get('/switch_active_aysem/{id}','SessionController@switch_active_sem');

Route::get('/semestermanagement', 'SemesterManagementController@index');
Route::post('/semestermanagement', 'SemesterManagementController@create');

Route::get('/usermanagement', 'UserManagementController@index');
Route::post('/usermanagement', 'UserManagementController@store');

Route::get('/usagestatistics/encode', 'UsageStatisticsController@encode');
Route::post('/usagestatistics/encode/{id}', 'UsageStatisticsController@gotoform');

Route::get('/usagestatistics/encode/{id}','UsageStatisticsController@gotoform');
Route::post('/usagestatistics/index/{id}', 'UsageStatisticsController@submitform');