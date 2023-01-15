<?php

use App\Http\Controllers\AuthController;
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

Route::prefix('v1')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        //logout
        Route::post('/logout', [AuthController::class, 'logout']);

        //user
        Route::get('/get-user-classes-by-cbl','Auth\UserController@getUserbyCanbolop');


        Route::get('/activities','Auth\ActivityController@index');
        Route::post('/child-activities','Auth\ChildActivityController@store');
        Route::get('/receive-activities','Auth\ChildActivityController@getActivitiesReceive');
        Route::post('/child-activity-forward/{id}','Auth\ChildActivityController@forwardChildActivity');
        Route::get('/child-activity-responsiable','Auth\ChildActivityController@getActivityResponsiable');

        //điểm danh
        Route::get('/checkList-activities','Auth\ChildActivityController@getActivitiesForCheckList');
        Route::get('/checkList-activities-users/{activity_details_id}','Auth\ChildActivityController@getUserForCheckList');




        // class
        Route::get('/classes','Auth\ClassesController@index');
    });
});



