<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\RoleUtils;
use App\Models\Classes;
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
                ->select('student_class_meet_score.*', 'tieu_chi.name', 'tieu_chi.note', 'tieu_chi.max_score')
                ->where('id_study_time', $id_study_time)
                ->where('id_user', $user->id)
                ->orderBy('id_tieu_chi')
                ->get();
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
                        ->select('student_class_meet_score.*', 'tieu_chi.max_score')
                        ->where('id_study_time', $id_study_time)
                        ->where('id_user', $student->id)
                        ->orderBy('id_tieu_chi')
                        ->get();
                    $student->scoreList = $scoreList;
                }
                return $this->sendResponse($studentLists, __('message.failed.get_list',['atribute' => 'điểm tự đánh giá']));
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm tự đánh giá']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
