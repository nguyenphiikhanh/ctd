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
        Route::middleware('role.admin')->group(function(){
            //khóa đào tạo
            Route::get('/terms','Auth\TermController@index');
            Route::post('/terms','Auth\TermController@store');
            Route::put('/terms/{id}','Auth\TermController@update');

            // khối ngành đào tạo(Sư phạm vs Ngoài sư phạm)
            Route::get('/class-types','Auth\ClassTypeController@index');

            //khoa
            Route::get('/faculties','Auth\FacultyController@index');
            Route::post('/faculties','Auth\FacultyController@store');

            // Sinh viên
            Route::get('/students/class/{id}','Auth\StudentController@index');
            Route::post('/student','Auth\StudentController@store');
            Route::put('/student/cbSetting','Auth\StudentController@updateCbSetting');

            // Lớp
            Route::post('/classes','Auth\ClassesController@store');
            Route::get('/classes','Auth\ClassesController@getClasses');
            Route::get('/class/{id}','Auth\ClassesController@show');
        });

        // bql Đoàn khoa
        Route::middleware('role.faculty')->group(function(){
            //Lớp
            Route::get('/class-list','Auth\ClassesController@index');

            // sinh vien
            Route::get('/student/faculty/{id}','Auth\StudentController@getStudentByFaculty');

            //Hoạt động
            Route::get('/activities','Auth\ActivityController@index');
            Route::get('/child-activities','Auth\ChildActivityController@index');
            Route::post('/child-activities','Auth\ChildActivityController@store');
            Route::put('/child-activities/{id}','Auth\ChildActivityController@update');

            //update giải thưởng
            Route::put('/user-activity/{id}/update','Auth\ChildActivityController@awardUpdate');
        });

        Route::middleware('role.cbOrStudent')->group(function(){
            //sinh vien
            Route::get('/student/class','Auth\StudentController@getStudentbyCanbolop');

            // hoạt động
            Route::post('/child-activity-forward/{id}','Auth\ChildActivityController@forwardChildActivity');
            Route::get('/child-activity-responsiable','Auth\ChildActivityController@getActivityResponsiable');

            //minh chứng
            Route::get('/prooves','Auth\ChildActivityController@getProoves');
            Route::post('/proof/store','Auth\ChildActivityController@storeProof'); // upload minh chứng

            //điểm danh
            Route::get('/checkList-activities','Auth\ChildActivityController@getActivitiesForCheckList');
            Route::get('/checkList-activities-users/{activity_details_id}','Auth\ChildActivityController@getUserForCheckList');
            Route::put('/checkList-for-user/{id_user}/{act_id}','Auth\ChildActivityController@updateUserCheckList');
        });


        // danh sách user dự thi(phần thi NVSP hoặc tiểu ban NCKH)
        Route::get('/child-activity/{id}/users','Auth\ChildActivityController@getUserActivity');
        // hoạt động
        Route::get('/receive-activities','Auth\ChildActivityController@getActivitiesReceive');
    });
});



