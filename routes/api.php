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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Auth API Custom
Route::middleware(['auth.API.check'])->prefix('v1')->group(function(){
    Route::get('/activities','Auth\ActivityController@index');
    Route::post('/child-activities','Auth\ChildActivityController@store');
    Route::get('/receive-activities','Auth\ChildActivityController@getActivitiesReceive');
    Route::get('/child-activity-forward/{id}','Auth\ChildActivityController@forwardChildActivity');


    // class
    Route::get('/classes','Auth\ClassesController@index');
});



