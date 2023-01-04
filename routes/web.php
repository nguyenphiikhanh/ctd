<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dang-nhap','AuthController@index')->name('login.index');
Route::post('/dang-nhap','AuthController@login')->name('login.login');
Route::get('/logout','AuthController@logout')->name('logout');

Route::middleware(['auth.check'])->group(function(){
    // Route::get('/','Auth\DashBoardController@index')->name('dashboard');
    // Route::get('/{any?}', 'SpaController@index')->where('any', '^(?!nova|admin|horizon).*$')->name('dashboard');
    // Nhiệm vụ
    Route::get('/nhiem-vu','Auth\ChildActivityController@index')->name('task.index');
    Route::get('/nhiem-vu/create','Auth\ChildActivityController@create')->name('task.create');

});


// Auth API Custom
Route::middleware(['auth.API.check'])->prefix('v1/api')->group(function(){
    Route::get('/activities','Auth\ActivityController@index');
    Route::post('/child-activities','Auth\ChildActivityController@store');

    // class
    Route::get('/get-class-cb-khoa','Auth\ClassesController@getClassByCbKhoa');
});


