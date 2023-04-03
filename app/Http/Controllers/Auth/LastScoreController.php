<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
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
                'last_score.last_score', 'last_score.sum_score','last_score.note', 'last_score.rank', 'last_score.id')
                ->orderBy(DB::raw("SUBSTR(users.ten, 1 ,1)"))
                ->where('last_score.id_study_time', $id_study_time)
                ->where('users.id_class', $id_class)
                ->get();
            foreach($studentScoreList as $student){
                $student->id = (int) $student->id;
                $student->last_score = (float) $student->last_score;
                $student->sum_score = (float) $student->sum_score;
            }
            return $this->sendResponse($studentScoreList,__('message.success.get_list',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
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
                }else $rank = AppUtils::RANK_YEU;
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
