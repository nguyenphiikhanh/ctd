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
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/activities','Auth\ActivityController@index');
        Route::post('/child-activities','Auth\ChildActivityController@store');
        Route::get('/receive-activities','Auth\ChildActivityController@getActivitiesReceive');
        Route::get('/child-activity-forward/{id}','Auth\ChildActivityController@forwardChildActivity');


        // class
        Route::get('/classes','Auth\ClassesController@index');
    });
});



