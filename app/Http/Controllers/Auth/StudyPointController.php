<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudyPointRequest;
use App\Http\Utils\ResponseUtils;
use App\Imports\StudyPointImport;
use App\Models\StudyTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class StudyPointController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        try{
            $id_study_time = $request->get('id_study_time');
            $id_class = $request->get('id_class');
            $studyPoints = DB::table('users')
                ->leftJoin('study_points', 'users.id', 'study_points.id_user')
                ->select(DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"), 'study_points.*')
                ->where('users.id_class', $id_class)
                ->where('study_points.id_study_time', $id_study_time)
                ->get();
            return $this->sendResponse($studyPoints, __('message.success.get_list',['atribute' => 'điểm học tập']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm học tập']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudyPointRequest $request)
    {
        //
        try{
            $file = $request->file('file');
            $import = Excel::import(new StudyPointImport, $file);
            if($import){
                $this->sendResponse('', __('message.success.update',['atribute' => 'điểm học tập']));
            }
            else{
                return $this->sendError(__('message.failed.update',['atribute' => 'điểm học tập']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm học tập']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
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
