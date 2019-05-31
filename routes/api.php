<?php

use Illuminate\Http\Request;

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

// AUTH
Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@register');
Route::middleware('auth:api')->post('/logout', 'LogoutController@logout');

// Admin
Route::post('/register_admin', 'RegisterAdminController@register');

// CLOCK IN
Route::middleware('auth:api')->post('/clock/in', 'ClockInController@clockIn');
Route::middleware('auth:api')->post('/clock/out/{timeLogId}', 'ClockOutController@clockOut');
Route::middleware('auth:api')->get('/timesheet', 'TimeSheetController@getTimeSheetByDate');
Route::middleware('auth:api')->get('/current/timesheet', 'TimeSheetController@getCurrentTimeSheet');
Route::middleware('auth:api')->get('/all/timesheets/organization', 'TimeSheetController@getTimeSheetsByOrganization');

// INVITE
Route::middleware('auth:api')->post('/invite', 'UserInvitationController@inviteNewUser');

// User 
Route::middleware('auth:api')->get('user/profile', 'UserController@profile');

// SETTINGS
Route::middleware('auth:api')->post('/update/location/{programId?}/', 'LocationController@update');

// Organization Settings
Route::middleware('auth:api')->post('/organization/settings/categories', 'AdminSettingsController@updateCategories');
Route::middleware('auth:api')->post('/organization/settings/pay/period/{payPeriodTypeId}', 'AdminSettingsController@updatePayPeriod');
Route::middleware('auth:api')->post('/organization/settings', 'AdminSettingsController@getOrganizationSettings');

// CATEGORY
Route::middleware('auth:api')->get('/category/all', 'CategoriesController@allCategory');
Route::middleware('auth:api')->post('/category/create', 'CategoriesController@createCategory');
Route::middleware('auth:api')->put('/category/update/{categoryId}', 'CategoriesController@updateCategory');
Route::middleware('auth:api')->delete('/category/delete/{categoryId}', 'CategoriesController@deleteCategory');
