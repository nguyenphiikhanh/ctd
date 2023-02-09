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
        // admin
        //khóa đào tạo
        Route::get('/terms','Auth\TermController@index');
        Route::post('/terms','Auth\TermController@store');

        //khoa
        Route::get('/faculties','Auth\FacultyController@index');
        Route::post('/faculties','Auth\FacultyController@store');

        //Lớp
        Route::get('/class-list','Auth\ClassesController@index');
        Route::get('/classes','Auth\ClassesController@getClasses');
        Route::get('/class/{id}','Auth\ClassesController@show');
        Route::post('/classes','Auth\ClassesController@store');

        // Sinh viên
        Route::get('/students/class/{id}','Auth\StudentController@index');
        Route::post('/student','Auth\StudentController@store');
        Route::put('/student/cbSetting','Auth\StudentController@updateCbSetting');
        Route::get('/student/faculty/{id}','Auth\StudentController@getStudentByFaculty');
        Route::get('/student/class','Auth\StudentController@getStudentbyCanbolop');

        // khối ngành đào tạo(Sư phạm vs Ngoài sư phạm)
        Route::get('/class-types','Auth\ClassTypeController@index');

        //user


        // hoạt động
        Route::get('/activities','Auth\ActivityController@index');
        Route::get('/child-activities','Auth\ChildActivityController@index');
        Route::post('/child-activities','Auth\ChildActivityController@store');
        Route::get('/receive-activities','Auth\ChildActivityController@getActivitiesReceive');
        Route::post('/child-activity-forward/{id}','Auth\ChildActivityController@forwardChildActivity');
        Route::get('/child-activity-responsiable','Auth\ChildActivityController@getActivityResponsiable');
        Route::get('/child-activity/{id}/users','Auth\ChildActivityController@getUserActivity');
        //update giải thưởng
        Route::put('/user-activity/{id}/update','Auth\ChildActivityController@awardUpdate');
        //minh chứng
        Route::get('/prooves','Auth\ChildActivityController@getProoves');
        Route::post('/proof/store','Auth\ChildActivityController@storeProof'); // upload minh chứng

        //điểm danh
        Route::get('/checkList-activities','Auth\ChildActivityController@getActivitiesForCheckList');
        Route::get('/checkList-activities-users/{activity_details_id}','Auth\ChildActivityController@getUserForCheckList');
        Route::put('/checkList-for-user/{id_user}/{act_id}','Auth\ChildActivityController@updateUserCheckList');
    });
});



