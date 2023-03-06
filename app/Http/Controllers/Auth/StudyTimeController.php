<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\RoleUtils;
use App\Http\Utils\TcUtils;
use App\Models\Faculty;
use App\Models\StudyTime;
use App\Models\StudyYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function getCurrentStudyTimeFacultySettings(){
        try{
            $user = Auth::user();
            $id_faculty = null;
            if($user->role == RoleUtils::ROLE_BI_THU_DOAN || $user->role == RoleUtils::ROLE_CVHT){
                $id_faculty = $user->id_khoa;
            }
            else{
                $faculty = DB::table('users')
                    ->join('classes','classes.id', 'users.id_class')
                    ->join('faculties', 'faculties.id', 'classes.id_faculty')
                    ->where('users.id', $user->id)
                    ->first();
                $id_faculty = $faculty->id;
            }
            $studyTimeCurrent = DB::table('study_times')
                ->join('study_years', 'study_years.id', 'study_times.id_study_year')
                ->join('study_terms', 'study_terms.id', 'study_times.id_study_term')
                ->leftJoin('class_meet_faculty_settings', function($leftJoin) use ($id_faculty){
                    $leftJoin->on('class_meet_faculty_settings.id_study_time','study_times.id')
                        ->where('id_faculty', $id_faculty);
                })
                ->select('study_times.id','study_years.year_name', 'study_terms.name','class_meet_faculty_settings.end_time_class_meet')
                ->latest('study_times.id')
                ->first();
            return $this->sendResponse($studyTimeCurrent, __('message.success.show',['atribute' => 'kỳ học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.show',['atribute' => 'kỳ học']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createOrUpdateFalcultyClassMeetSettings(Request $request, $id_study_time){
        try{
            $user = Auth::user();
            $setting = DB::table('class_meet_faculty_settings')
                ->where('id_faculty', $user->id_khoa)
                ->where('id_study_time', $id_study_time)
                ->first();
            DB::connection('mysql')->transaction(function() use ($user, $setting, $request, $id_study_time){
                if(!$setting){
                    $studentIds = DB::table('users')
                        ->join('classes', 'classes.id', 'users.id_class')
                        ->join('faculties','faculties.id', 'classes.id_faculty')
                        ->where('faculties.id', $user->id_khoa)
                        ->where('users.role', RoleUtils::ROLE_CBL)
                        ->orWhere('users.role', RoleUtils::ROLE_SINHVIEN)
                        ->orWhere('users.role', RoleUtils::ROLE_LOP_TRUONG)
                        ->pluck('users.id');
                    foreach($studentIds as $id){
                        $createData = [];
                        $tcIds = TcUtils::TIEU_CHI_HOP_XET_IDS;
                        foreach($tcIds as $tcId){
                            $createData[] = [
                                'id_study_time' => $id_study_time,
                                'id_tieu_chi' => $tcId,
                                'id_user' => $id
                            ];
                        }
                        DB::table('student_class_meet_score')->insert($createData);
                    }
                }
                $end_time_class_meet = $request->get('end_time_class_meet');
                DB::table('class_meet_faculty_settings')
                    ->updateOrInsert(
                        ['id_faculty' => $user->id_khoa, 'id_study_time' => $id_study_time],
                        [
                            'end_time_class_meet' => $end_time_class_meet,
                        ]
                    );
            });
            return $this->sendResponse('', __('message.success.update',['atribute' => 'kỳ đánh giá']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'kỳ đánh giá']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
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
