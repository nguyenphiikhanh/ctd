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
            Route::post('/terms','Auth\TermController@store');
            Route::put('/terms/{id}','Auth\TermController@update');
            //khoa
            Route::get('/faculties','Auth\FacultyController@index');
            Route::post('/faculties','Auth\FacultyController@store');
            // Năm học
            Route::get('/years/lastest', 'Auth\StudyYearController@getLastestStudyYear');
            Route::post('/years', 'Auth\StudyYearController@store');
            Route::put('/years/{id}', 'Auth\StudyYearController@update');
            // Kỳ học
            Route::post('/study-times', 'Auth\StudyTimeController@store');
            Route::put('/study-times/{id}', 'Auth\StudyTimeController@update');
            Route::get('/study-terms', 'Auth\StudyTimeController@getStudyTerm');
        });

        // Quản lý Khoa
        Route::middleware('role.facultyMaster')->group(function(){
            // khối ngành đào tạo(Sư phạm vs Ngoài sư phạm)
            Route::get('/class-types','Auth\ClassTypeController@index');
            //Lớp
            Route::get('/class-list','Auth\ClassesController@index');
            Route::post('/classes','Auth\ClassesController@store');
            Route::get('/classes','Auth\ClassesController@getClasses');
            Route::get('/class/{id}','Auth\ClassesController@show');
            Route::put('/class/{id}/update-cvht','Auth\ClassesController@changeCvhtSetting');
            // Sinh viên
            Route::get('/students/class/{id}','Auth\StudentController@index');
            Route::post('/student','Auth\StudentController@store');
            Route::put('/student/cbSetting','Auth\StudentController@updateCbSetting');
            Route::put('/student/{id}','Auth\StudentController@update');
            Route::get('/student/faculty/{id}','Auth\StudentController@getStudentByFaculty');
            Route::get('/student/{id}','Auth\StudentController@show');
            // Cố vấn học tập
            Route::get('/user/cvht','Auth\UserController@getUserCvht');
            Route::post('/user/cvht','Auth\UserController@storeUserCvht');
            Route::put('/user/cvht/{id}','Auth\UserController@updateUserCvht');
            // Điểm học tập
            Route::get('/study-point','Auth\StudyPointController@index');
            Route::post('/study-point','Auth\StudyPointController@store');
            //  Điểm rèn luyện(form điểm cuối);
            Route::get('/last-score/{id_class}','Auth\LastScoreController@getLastScoreByClass');
            Route::put('/last-score','Auth\LastScoreController@updateLastScore');
        });

        // bí thư Liên Đoàn khoa
        Route::middleware('role.faculty')->group(function(){
            //Hoạt động
            Route::get('/activities','Auth\ActivityController@index');
            Route::get('/child-activities','Auth\ChildActivityController@index');
            Route::post('/child-activities','Auth\ChildActivityController@store');
            Route::put('/child_activities/{id}','Auth\ChildActivityController@update');
            Route::put('/child-activity/{id}/change-assignee','Auth\ChildActivityController@changeAssigneeSetting');
            Route::get('/child-activity/{id}/user-activities','Auth\ChildActivityController@getUserActivities');
            Route::put('/child-activity/{id}/user-activities','Auth\ChildActivityController@updateUserNckh');
            //update giải thưởng
            Route::put('/user-activity/{id}/update','Auth\ChildActivityController@awardUpdate');
            // Phụ trách phần thi
            Route::get('/user/assign-act','Auth\UserController@getUserAssigneeActivities');
            Route::post('/user/assign-act','Auth\UserController@storeUserAssignActivities');
            Route::put('/user/assign-act/{id}','Auth\UserController@updateUserAssignActivities');
            // Tổng hợp điểm
            Route::get('/points/nvsp','Auth\PointController@getNvspPointByStudyYear');
            Route::post('/points/nvsp','Auth\PointController@nvspCreatePoint'); // điểm tuần NVSP
            // Họp xét lớp
            Route::put('/study-times/{id}/faculty-setting','Auth\StudyTimeController@createOrUpdateFalcultyClassMeetSettings');
        });

        Route::middleware('role.cbOrStudent')->group(function(){
            //sinh vien
            Route::get('/student/class','Auth\StudentController@getStudentbyCanbolop');
            // hoạt động
            Route::post('/child-activity-forward/{id}','Auth\ChildActivityController@forwardChildActivity');
            Route::get('/child-activity-responsiable','Auth\ChildActivityController@getActivityResponsiable');
            // người dự thi, tham gia hoạt động
            Route::get('/activities-details/{id}/users','Auth\ActivityDetailController@getUser');
            Route::put('/activities-details/{id}/users','Auth\ActivityDetailController@updateUser');
            //minh chứng
            Route::get('/prooves','Auth\ChildActivityController@getProoves');
            Route::post('/proof/store','Auth\ChildActivityController@storeProof'); // upload minh chứng
            //điểm danh
            Route::get('/checkList-activities','Auth\ChildActivityController@getActivitiesForCheckList');
            Route::get('/checkList-activities-users/{activity_details_id}','Auth\ChildActivityController@getUserForCheckList');
            Route::put('/checkList-for-user/{id_user}/{act_id}','Auth\ChildActivityController@updateUserCheckList');

            //Điểm rèn luyện
            Route::get('/personal-score', 'Auth\PersonalScoreController@index');
            Route::post('/personal-score/proof', 'Auth\PersonalScoreController@sendProof');
            Route::get('/personal-score/proof', 'Auth\PersonalScoreController@getTcProoves');
            Route::get('/personal-score/confirm/{id}', 'Auth\PersonalScoreController@getListUserConfirm');
            Route::put('/personal-score/confirm-prooves/{id}', 'Auth\PersonalScoreController@confirmTcProoves');
            Route::get('/personal-score/student/{id_student}/time/{id_study_time}','Auth\PersonalScoreController@getStudentPersonalScore');
        });


        // Năm học
        Route::get('/years', 'Auth\StudyYearController@index');
        //khóa đào tạo
        Route::get('/terms','Auth\TermController@index');
        // danh sách user dự thi(phần thi NVSP hoặc tiểu ban NCKH)
        Route::get('/child-activity/{id}/users','Auth\ChildActivityController@getUserActivity');
        // hoạt động
        Route::get('/receive-activities','Auth\ChildActivityController@getActivitiesReceive');
        // kì học
        Route::get('/study-times', 'Auth\StudyTimeController@index');
        // setting họp xét lớp cho kì học
        Route::get('/study-times/current', 'Auth\StudyTimeController@getCurrentStudyTimeFacultySettings');
        // Tiêu chí
        Route::get('/tieu-chi/self', 'Auth\TcController@getTcSelf');
        // Điểm đánh giá cá nhân
        Route::get('/class-meet-score/{id_study_time}', 'Auth\ClassMeetScoreController@getClassMeetScore');
        Route::put('/class-meet-score/{id_study_time}/student-person-tc/{id}', 'Auth\ClassMeetScoreController@updatePersonClassMeetScore');
        Route::get('/class-meet-score/class/{id_class}', 'Auth\ClassMeetScoreController@getMeetScoreByClass');
        Route::get('/class-meet-score/check-list/{id_class}', 'Auth\ClassMeetScoreController@getMeetScoreStudentCheckList');
    });
});



