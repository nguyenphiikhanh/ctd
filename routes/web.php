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
    Route::get('/','Auth\DashBoardController@index')->name('dashboard');
    // Route::get('/nhiem-vu')
});


