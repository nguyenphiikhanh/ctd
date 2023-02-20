<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseUtils;
use App\Models\StudyTime;
use App\Models\StudyYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudyTimeController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $studyTimes = StudyTime::select('study_times.start_time','study_times.end_time','study_times.status',
                            DB::raw("CONCAT(study_terms.name,' - năm học ',study_years.year_name) as name"))
                            ->leftJoin('study_years', 'study_years.id', 'study_times.id_study_year')
                            ->leftJoin('study_terms', 'study_terms.id', 'study_times.id_study_term')
                            ->orderByDesc('study_times.id')->get();
            return $this->sendResponse($studyTimes, __('message.success.get_list',['atribute' => 'kỳ học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'kỳ học']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getStudyTerm(){
        try{
            $studyTerms = DB::table('study_terms')->get();
            return $this->sendResponse($studyTerms, __('message.success.get_list',['atribute' => 'kỳ học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'kỳ học']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
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
        try{
            $lastStudyYear = StudyYear::latest()->first();
            $id_study_term = $request->get('id_study_term');
            $start_time = $request->get('start_time');
            $end_time = $request->get('end_time');
            StudyTime::create([
                'id_study_year' => $lastStudyYear->id,
                'id_study_term' => $id_study_term,
                'start_time' => $start_time,
                'end_time' => $end_time
            ]);
            return $this->sendResponse('', __('message.success.create',['atribute' => 'kỳ học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'kỳ học']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
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
