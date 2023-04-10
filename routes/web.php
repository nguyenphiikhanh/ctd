<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpaController;
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

Route::get('/', [SpaController::class, 'intro'])->name('intro');
Route::get('/dang-nhap', [AuthController::class, 'index'])->name('login');

Route::get('/{any?}', 'SpaController@index')->where('any', '^(?!nova|admin|horizon).*$');



