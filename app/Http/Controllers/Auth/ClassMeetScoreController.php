<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
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
            DB::table('student_class_meet_score')
                ->where('id_study_time', $id_study_time)
                ->where('id_tieu_chi', $id_tieu_chi)
                ->where('id_user', $user->id)
                ->update([
                    'self_score' => $score
                ]);
            return $this->sendResponse('', __('message.success.update',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
