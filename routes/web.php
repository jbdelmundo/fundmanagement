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
Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@index');

Route::get('/balance', 'DashboardController@balance');
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::get('/switch_active_dept/{id}','SessionController@switch_active_dept');
Route::get('/switch_active_aysem/{id}','SessionController@switch_active_sem');
Route::get('/switch_active_user/{id}','SessionController@switch_active_user');


/*
	RESTRICTED ROUTES: Permission is allowed according to module number
	See app/Http/Middleware/ModulePermission for details
	1 - Collection
	2 - Endorsement
	3 - Requests
	4 - Approval
	5 - UserManagement
	6 - Semester Management
	7 - Purchase History
	8 - Refunds
	9 - Module Permissions
	10 - Usage Statistics Viewing
	11 - Usage Statistics Encoding
*/

Route::get('/collection', 'CollectionController@index')->middleware('permit:1');
Route::post('/collection', 'CollectionController@store')->middleware('permit:1');
Route::get('/collection/view/{id}', 'CollectionController@view_individual')->middleware('permit:1');
Route::get('/collection/{aysem}', 'CollectionController@show')->middleware('permit:1');

Route::get('/endorsement', 'RequestEndorsementController@index')->middleware('permit:2');
Route::post('/endorsement', 'RequestEndorsementController@create')->middleware('permit:2');
Route::post('/endorsement/reject', 'RequestEndorsementController@reject')->middleware('permit:2');
Route::get('/endorsement/remove/{request_id}', 'RequestEndorsementController@remove')->middleware('permit:2');

Route::get('/requests', 'RequestsController@index')->middleware('permit:3');
Route::post('/requests', 'RequestsController@create')->middleware('permit:3');

Route::get('/approval', 'ApprovalController@index')->middleware('permit:4');
Route::post('/approval', 'ApprovalController@create')->middleware('permit:4');
Route::post('/approval/reject', 'ApprovalController@reject')->middleware('permit:4');
Route::get('/approval/remove/{request_id}', 'ApprovalController@remove')->middleware('permit:4');

Route::get('/usermanagement', 'UserManagementController@index')->middleware('permit:5');
Route::post('/usermanagement', 'UserManagementController@store')->middleware('permit:5');
Route::post('/usermanagement/changepassword', 'UserManagementController@changepassword')->middleware('permit:5');

Route::get('/semestermanagement', 'SemesterManagementController@index')->middleware('permit:6');
Route::post('/semestermanagement', 'SemesterManagementController@create')->middleware('permit:6');

Route::get('/purchasehistory', 'PurchaseHistoryController@index')->middleware('permit:7');
Route::get('/purchasehistory/all', 'PurchaseHistoryController@seeall')->middleware('permit:7');

Route::get('/refunds', 'RefundsController@index')->middleware('permit:8');
Route::post('/refunds', 'RefundsController@create')->middleware('permit:8');


Route::get('/module_permissions', 'ModulePermissionsController@index')->middleware('permit:9');
Route::get('/module_permissions/{id}', 'ModulePermissionsController@switch_active_user')->middleware('permit:9');
Route::post('/module_permissions', 'ModulePermissionsController@create')->middleware('permit:9');

Route::get('/usagestatistics/', 'UsageStatisticsController@view')->middleware('permit:10');
Route::get('/usagestatistics/{id}', 'UsageStatisticsController@viewstats')->middleware('permit:10');

Route::get('/usagestatistics_encoding', 'UsageStatisticsController@encode')->middleware('permit:11');
Route::get('/usagestatistics_encoding/{id}','UsageStatisticsController@gotoform')->middleware('permit:11');
Route::post('/usagestatistics_encoding/{id}', 'UsageStatisticsController@submitform')->middleware('permit:11');

Route::get('/manual_transactions/', 'ManualTransactionsController@index')->middleware('permit:12');
Route::post('/manual_transactions/add', 'ManualTransactionsController@add')->middleware('permit:12');
Route::post('/manual_transactions/deduct', 'ManualTransactionsController@deduct')->middleware('permit:12');

Route::get('/report_management/', 'ReportManagementController@index')->middleware('permit:13');

