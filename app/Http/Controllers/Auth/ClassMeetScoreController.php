<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\RoleUtils;
use App\Models\Classes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassMeetScoreController extends AppBaseController
{
    //
    public function getClassMeetScore($id_study_time){
        try{
            $user = Auth::user();
            $userScores = DB::table('student_class_meet_score')
                ->leftJoin('tieu_chi', 'tieu_chi.id', 'student_class_meet_score.id_tieu_chi')
                ->select('student_class_meet_score.*', 'tieu_chi.name', 'tieu_chi.note', 'tieu_chi.max_score', 'tieu_chi.min_score')
                ->where('id_study_time', $id_study_time)
                ->where('id_user', $user->id)
                ->orderBy('id_tieu_chi')
                ->get();
            foreach($userScores as $score){
                $score->cbl_score = (float) $score->cbl_score;
                $score->cvht_score = (float) $score->cvht_score;
                $score->max_score = (float) $score->max_score;
                $score->self_score = (float) $score->self_score;
                $score->min_score = (float) $score->min_score;
            }
            return $this->sendResponse($userScores, __('message.success.get_list',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePersonClassMeetScore(Request $request, $id_study_time, $id_tieu_chi){
        try{
            $user = Auth::user();
            $score = $request->get('score');
            $personFlg = $request->get('person_flg');
            $id_user = $request->get('id_user');
            if($personFlg){
                DB::table('student_class_meet_score')
                ->where('id_study_time', $id_study_time)
                ->where('id_tieu_chi', $id_tieu_chi)
                ->where('id_user', $user->id)
                ->update([
                    'self_score' => $score
                ]);
            }
            else{ //danh gia lop
                if($user->role == RoleUtils::ROLE_CVHT){ // điểm cvht chấm
                    DB::connection('mysql')->transaction(function() use($id_study_time, $id_tieu_chi, $id_user, $score){
                        DB::table('student_class_meet_score')
                        ->where('id_study_time', $id_study_time)
                        ->where('id_tieu_chi', $id_tieu_chi)
                        ->where('id_user', $id_user)
                        ->update([
                            'cvht_score' => $score
                        ]);
                        DB::table('personal_score')
                        ->where('id_study_time', $id_study_time)
                        ->where('id_tieu_chi', $id_tieu_chi)
                        ->where('id_user', $id_user)
                        ->update([
                            'score' => $score,
                            'status' => AppUtils::SCORE_HOAN_THANH
                        ]);
                    });
                }
                else{ // điểm cbl chấm
                    DB::table('student_class_meet_score')
                    ->where('id_study_time', $id_study_time)
                    ->where('id_tieu_chi', $id_tieu_chi)
                    ->where('id_user', $id_user)
                    ->update([
                        'cbl_score' => $score
                    ]);
                }
            }
            return $this->sendResponse('', __('message.success.update',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMeetScoreByClass($id_class, Request $request){
        try{
            $class = Classes::find($id_class);
            if(!$class){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Lớp']));
                return;
            }
            else{
                $id_study_time = $request->id_study_time;
                $studentLists = DB::table('users')
                    ->where('id_class', $id_class)
                    ->get();
                foreach($studentLists as $student){
                    $scoreList = DB::table('student_class_meet_score')
                        ->join('tieu_chi', 'tieu_chi.id', 'student_class_meet_score.id_tieu_chi')
                        ->select('student_class_meet_score.*', 'tieu_chi.max_score','tieu_chi.min_score')
                        ->where('id_study_time', $id_study_time)
                        ->where('id_user', $student->id)
                        ->orderBy('id_tieu_chi')
                        ->get();
                    foreach($scoreList as $index => $score){
                        $score->cbl_score = (float) $score->cbl_score;
                        $score->cvht_score = (float) $score->cvht_score;
                        $score->max_score = (float) $score->max_score;
                        $score->self_score = (float) $score->self_score;
                        $score->min_score = (float)  $score->min_score;
                    }
                    $student->scoreList = $scoreList;
                }
                return $this->sendResponse($studentLists, __('message.success.get_list',['atribute' => 'điểm tự đánh giá']));
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm tự đánh giá']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMeetScoreStudentCheckList($id_class){
        try{
            $current = DB::table('study_times')->latest('id')->first();
            $students = User::query()->leftJoin('last_score', 'last_score.id_user', 'users.id')
                ->where(function($query){
                    $query->where('users.role', RoleUtils::ROLE_CBL)
                        ->orWhere('users.role', RoleUtils::ROLE_LOP_TRUONG)
                        ->orWhere('users.role', RoleUtils::ROLE_SINHVIEN);
                    })
                ->where('users.id_class', $id_class)
                ->where('last_score.id_study_time', $current->id)
                ->select('last_score.id', 'last_score.class_meet_check', 'users.username',
                DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"))
                ->orderBy(DB::raw("SUBSTR(users.ten, 1 , 1)"))
                ->get();
            foreach($students as $student){
                $student->id = (int) $student->id;
                $student->class_meet_check = (int) $student->class_meet_check;
            }
            return $this->sendResponse($students, __('message.success.get_list',['atribute' => 'sinh viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'sinh viên']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateMeetScoreStudentCheckList($id, Request $request){
        try{
            $status = $request->status;
            if($status == AppUtils::HOP_XET_VANG_MAT){
                DB::table('last_score')->where('id', $id)->update([
                    'class_meet_check' => AppUtils::HOP_XET_VANG_MAT,
                    'last_score' => 0,
                    'note' => 'Vắng tham gia họp lớp',
                ]);
            }
            else{
                DB::table('last_score')->where('id', $id)->update([
                    'class_meet_check' => AppUtils::HOP_XET_CO_MAT,
                ]);
            }
            return $this->sendResponse("", __('message.success.update',['atribute' => 'điểm danh']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm danh họp lớp']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
