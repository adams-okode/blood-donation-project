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

// Route::get('testBloodGroup/{group}', 'PersonController@testBloodGroup');
Route::post('createUser', 'PersonController@createUser');
Route::post('authenticateUser', 'PersonController@authenticateUser');

Route::middleware('api.security')->group(function () {
    Route::put('updateUser/{id}', 'PersonController@updateUser');
    Route::post('setBloodGroup/{id}', 'PersonController@setBloodGroup');
    Route::post('sendBloodDonorRequest', 'DonationController@sendBloodDonorRequest');
    Route::post('acceptBloodDonorRequest', 'DonationController@acceptBloodDonorRequest');
    Route::get('getUserNotifications/{id}', 'NotificationController@getUserNotifications');
    Route::get('getNotificationDetails/{id}', 'NotificationController@getNotificationDetails');
    Route::get('readNotification/{id}', 'NotificationController@readNotification');
});
