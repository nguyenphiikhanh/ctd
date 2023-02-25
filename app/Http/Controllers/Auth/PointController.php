<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Utils\AppUtils;
use App\Http\Utils\NvspUtils;
use App\Http\Utils\ResponseUtils;
use App\Models\StudyTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PointController extends AppBaseController
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

    public function nvspCreatePoint(){
        try{
            DB::connection('mysql')->beginTransaction();
            $studyTime = StudyTime::join('study_years', 'study_times.id_study_year', 'study_years.id')
            ->select('study_times.*', 'study_years.nvsp_data_stored')
            ->latest('study_times.id')->first();
            if($studyTime->nvsp_data_stored == AppUtils::VALID_VALUE){
                return $this->sendError('Dữ liệu điểm Nghiệp vụ Sư phạm của năm hiện tại đã được cập nhật.', ResponseUtils::HTTP_UNPROCESSABLE_ENTITY);
                return;
            }
            $studentIds = DB::table('terms')
                ->join('classes', 'terms.id', 'classes.id_term')
                ->rightJoin('users','classes.id', 'users.id_class')
                ->where('terms.setting_flg', AppUtils::VALID_VALUE)
                ->pluck('users.id');
            foreach($studentIds as $studentId){
                $user_activities = DB::table('activities_details')
                ->join('child_activities', 'child_activities.id', 'activities_details.id_child_activity')
                ->join('user_activities', 'user_activities.id_activities_details', 'activities_details.id')
                ->select('activities_details.*')
                ->where('child_activities.id_study_time', $studyTime->id)
                ->where('child_activities.id_activity', AppUtils::HOAT_DONG_NVSP)
                ->where('activities_details.level', '!=', AppUtils::LEVEL_TOA_DAM)
                ->where('user_activities.id_user', $studentId)
                ->get();

                if(!count($user_activities)){
                    Log::debug($studentId);
                    DB::table('nvsp_point')->insert([
                        'id_study_year' => $studyTime->id_study_year,
                        'id_user' => $studentId,
                        'level' => NvspUtils::LEVEL_KHONG_DAT,
                        'level_text' => NvspUtils::TEXT_LEVEL_KHONG_DAT,
                        'note' => NvspUtils::TEXT_LEVEL_KHONG_DAT
                    ]);
                    return $this->sendError("Thằng số #$studentId không thi phần thi NVSP nào");
                    break;
                }

                // $user_join_activities = DB::table('activities_details')
                // ->join('child_activities', 'child_activities.id', 'activities_details.id_child_activity')
                // ->join('user_join_activities', 'user_join_activities.id_activities_details', 'activities_details.id')
                // ->select('activities_details.*')
                // ->where('child_activities.id_study_time', $studyTime->id)
                // ->where('child_activities.id_activity', AppUtils::HOAT_DONG_NVSP)
                // ->where('activities_details.level', '!=', AppUtils::LEVEL_TOA_DAM)
                // ->where('user_join_activities.id_user', $studentId)
                // ->where('user_join_activities.id_user')
                // ->get();
            }
            return $this->sendResponse('', __('message.success.update', ['atribute' => 'điểm rèn luyện NVSP']));
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update', ['atribute' => 'điểm rèn luyện NVSP']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
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
