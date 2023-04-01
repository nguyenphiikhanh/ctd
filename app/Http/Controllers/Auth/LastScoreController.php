<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
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
                'last_score.last_score', 'last_score.sum_score','last_score.note', 'last_score.rank')
                ->orderBy('users.ten')
                ->where('last_score.id_study_time', $id_study_time)
                ->where('users.id_class', $id_class)
                ->get();
            foreach($studentScoreList as $student){
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
