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

Route::get('/home', 'HomeController@index');

Route::get('/switch_active_dept/{id}','SessionController@switch_active_dept');
Route::get('/switch_active_aysem/{id}','SessionController@switch_active_sem');

Route::get('/collection', 'CollectionController@index')->middleware('permit:1');
Route::post('/collection', 'CollectionController@store')->middleware('permit:1');
Route::get('/collection/{aysem}', 'CollectionController@show')->middleware('permit:1');

Route::get('/endorsement', 'RequestEndorsementController@index')->middleware('permit:2');
Route::post('/endorsement', 'RequestEndorsementController@create')->middleware('permit:2');
Route::get('/endorsement/remove/{request_id}', 'RequestEndorsementController@remove')->middleware('permit:2');

Route::get('/requests', 'RequestsController@index')->middleware('permit:3');
Route::post('/requests', 'RequestsController@create')->middleware('permit:3');

Route::get('/approval', 'ApprovalController@index')->middleware('permit:4');
Route::post('/approval', 'ApprovalController@create')->middleware('permit:4');

Route::get('/usermanagement', 'UserManagementController@index')->middleware('permit:5');
Route::post('/usermanagement', 'UserManagementController@store')->middleware('permit:5');

Route::get('/semestermanagement', 'SemesterManagementController@index')->middleware('permit:6');
Route::post('/semestermanagement', 'SemesterManagementController@create')->middleware('permit:6');

Route::get('/purchasehistory', 'PurchaseHistoryController@index')->middleware('permit:7');
Route::get('/purchasehistory/all', 'PurchaseHistoryController@seeall')->middleware('permit:7');

Route::get('/refunds', 'RefundsController@index')->middleware('permit:8');
Route::post('/refunds', 'RefundsController@create')->middleware('permit:8');


Route::get('/module_permissions', 'ModulePermissionsController@index')->middleware('permit:9');
Route::get('/module_permissions/{id}', 'ModulePermissionsController@switch_active_user')->middleware('permit:9');
Route::post('/module_permissions', 'ModulePermissionsController@create')->middleware('permit:9');

Route::get('/usagestatistics/encode', 'UsageStatisticsController@encode');
Route::post('/usagestatistics/encode/{id}', 'UsageStatisticsController@gotoform');

Route::get('/usagestatistics/encode/{id}','UsageStatisticsController@gotoform');
Route::post('/usagestatistics/index/{id}', 'UsageStatisticsController@submitform');

