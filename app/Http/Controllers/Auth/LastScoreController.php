<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\RoleUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LastScoreController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getLastScoreByClass($id_class, Request $request){
        try{
            $id_study_time = $request->get('id_study_time');
            $studentScoreList = DB::table('users')
                ->leftJoin('last_score', 'last_score.id_user', 'users.id')
                ->select(DB::raw("CONCAT(users.ho,' ', users.ten) as fullname"), 'users.username',
                'last_score.last_score','last_score.note', 'last_score.rank', 'last_score.id', 'last_score.id_user')
                ->orderByRaw("SUBSTRING(users.ten, 1 ,1) ASC")
                ->where('last_score.id_study_time', $id_study_time)
                ->where('users.id_class', $id_class)
                ->get();
            DB::connection('mysql')->transaction(function() use($studentScoreList, $id_study_time){
                foreach($studentScoreList as $student){
                    $sum_score = DB::table('personal_score')
                        ->select(DB::raw("SUM(score) as sum_score"))
                        ->where('id_study_time', $id_study_time)
                        ->where('id_user', $student->id_user)
                        ->groupBy('id_study_time', 'id_user')
                        ->first();
                    $student->id = (int) $student->id;
                    $student->id_user = (int) $student->id_user;
                    $student->last_score = (float) $student->last_score;
                    $student->sum_score = (float) $sum_score->sum_score ?? 0;
                }
            });
            return $this->sendResponse($studentScoreList,__('message.success.get_list',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getReportData($id_class, $id_study_time){
        try{
            $dataReports = (object)[];
            $cvht = DB::table('classes')
                ->join('users', 'users.id', 'classes.id_user_cvht')
                ->select(DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"))
                ->where('classes.id', $id_class)
                ->first();
            $user_uncheck = DB::table('users')
                ->join('last_score', 'last_score.id_user', 'users.id')
                ->leftJoin('classes', 'classes.id', 'users.id_class')
                ->select('users.id', DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"), 'users.username',
                'last_score.class_meet_check')
                ->where('classes.id', $id_class)
                ->where('last_score.id_study_time', $id_study_time)
                ->where('last_score.class_meet_check', '!=' , AppUtils::VALID_VALUE)
                ->get();
            foreach($user_uncheck as $user){
                $sum_score = DB::table('personal_score')
                    ->where('id_user', $user->id)
                    ->where('id_study_time', $id_study_time)
                    ->select(DB::raw("SUM(score) as sum_score"))
                    ->groupBy('id_study_time', 'id_user')
                    ->first();
                $user->sum_score = $sum_score->sum_score;
            }
            $student_list = DB::table('users')
                ->leftJoin('classes', 'classes.id', 'users.id_class')
                ->select(DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"), 'users.username', 'users.role')
                ->where(function($q){
                    $q->where( 'users.role', RoleUtils::ROLE_CBL)
                        ->orWhere('users.role', RoleUtils::ROLE_LOP_TRUONG)
                        ->orWhere('users.role', RoleUtils::ROLE_SINHVIEN);
                    })
                ->where('classes.id', $id_class)
                ->get();
            $student_unsubmited = DB::table('users')
                ->join('student_class_meet_score', 'student_class_meet_score.id_user', 'users.id')
                ->leftJoin('classes', 'classes.id', 'users.id_class')
                ->select(DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"), 'users.username',
                DB::raw("SUM(student_class_meet_score.self_score) as sum_score"))
                ->where('classes.id', $id_class)
                ->where('student_class_meet_score.id_study_time', $id_study_time)
                ->groupBy('student_class_meet_score.id_study_time', 'student_class_meet_score.id_user',
                'users.ho','users.ten', 'users.username')
                ->havingRaw("SUM(student_class_meet_score.self_score) = ?", array(0))
                ->get();
            $score_data = DB::table('users')
                ->join('last_score', 'last_score.id_user', 'users.id')
                ->leftJoin('classes', 'classes.id', 'users.id_class')
                ->select('last_score.*')
                ->where('classes.id', $id_class)
                ->where('last_score.id_study_time', $id_study_time)
                ->get();
            $dataReports->cvht = $cvht->fullname;
            $dataReports->student_list = $student_list;
            $dataReports->user_uncheck = $user_uncheck;
            $dataReports->student_unsubmited = $student_unsubmited;
            $dataReports->score_data = $score_data;
            return $this->sendResponse($dataReports, __('message.success.get_list',['atribute' => 'báo cáo']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'báo cáo']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function updateLastScore(Request $request)
    {
        //
        try{
            $id = $request->get('id');
            $note = $request->get('note');
            $last_score = $request->get('last_score', 0);
            $rank = 'Chưa xếp loại';
            // if($last_score != 0){
                if($last_score >= 90 && $last_score <= 100){
                    $rank = AppUtils::RANK_XUAT_SAC;
                }elseif($last_score >= 80 && $last_score < 90){
                    $rank = AppUtils::RANK_TOT;
                }elseif($last_score >= 65 && $last_score < 80){
                    $rank = AppUtils::RANK_KHA;
                }elseif($last_score >= 50 && $last_score < 65){
                    $rank = AppUtils::RANK_TRUNG_BINH;
                }elseif($last_score >= 35 && $last_score < 50){
                    $rank = AppUtils::RANK_YEU;
                }else $rank = AppUtils::RANK_KEM;
            // }
            DB::table('last_score')->where('id', $id)->update([
                'last_score' => $last_score,
                'note' => $note,
                'rank' => $rank,
            ]);
            return $this->sendResponse('', __('message.success.update',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update', ['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
