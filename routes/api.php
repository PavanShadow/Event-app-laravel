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

Route::post('enquiries', 'EnquiryController@store');

Route::post('events','EventController@store');
Route::post('events/get','EventController@getEventsOnDate');

Route::post('events/delete', 'EventController@deleteEvent');
Route::post('events/edit', 'EventController@editEvent');

Route::group([

    'middleware' => 'api',
    
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});