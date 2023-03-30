<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Utils\AppUtils;
use App\Http\Utils\NvspUtils;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\TcUtils;
use App\Models\NvspPoint;
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

    public function getNvspPointByStudyYear(Request $request){
        $id_class = $request->id_class;
        $id_study_year = $request->id_study_year;
        $nvspPoints = DB::table('nvsp_points')
            ->join('users','users.id', 'nvsp_points.id_user')
            ->select('nvsp_points.*', DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"),'users.username')
            ->where('users.id_class', $id_class)
            ->where('nvsp_points.id_study_year', $id_study_year)
            ->orderBy('users.ten')
            ->get();
       return $this->sendResponse($nvspPoints, __('message.success.get_list',['atribute' => 'điểm rèn luyện NVSP']));
    }

    public function nvspCreatePoint(){
        try{
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
            DB::connection('mysql')->transaction(function() use ($studentIds, $studyTime){
                $current = DB::table('study_times')->latest('id')->first();
                DB::table('study_years')->latest('id')->update([
                    'nvsp_data_stored' => AppUtils::VALID_VALUE,
                ]);
                foreach($studentIds as $studentId){
                    $user_join_activities = DB::table('activities_details')
                    ->join('child_activities', 'child_activities.id', 'activities_details.id_child_activity')
                    ->join('user_join_activities', 'user_join_activities.id_activities_details', 'activities_details.id')
                    ->select('user_join_activities.*')
                    ->where('child_activities.id_study_time', $studyTime->id)
                    ->where('child_activities.id_activity', AppUtils::HOAT_DONG_NVSP)
                    ->where('activities_details.level', AppUtils::LEVEL_TOA_DAM)
                    ->where('user_join_activities.id_user', $studentId)
                    ->get();
                    if(!count($user_join_activities)){ // Không tham gia tọa đàm
                        DB::table('nvsp_points')->insert([
                            'id_study_year' => $studyTime->id_study_year,
                            'id_user' => $studentId,
                            'level' => NvspUtils::LEVEL_KHONG_DAT,
                            'level_text' => NvspUtils::TEXT_LEVEL_KHONG_DAT,
                            'note' => 'Không tham gia tọa đàm'
                        ]);
                        DB::table('personal_score') //Tham gia đầy đủ các buổi rèn luyện NVSP =>  không hoàn thành
                            ->where('id_study_time', $current->id)
                            ->where('id_user', $studentId)
                            ->where('id_tieu_chi', TcUtils::TIEU_CHI_THAM_GIA_NVSP)
                            ->update([
                                'status' => AppUtils::SCORE_HOAN_THANH
                            ]);
                        continue;
                    }else {
                        $statusFlg = true;
                        foreach($user_join_activities as $act){  // check status
                            if($act->status == AppUtils::STATUS_CHO_DUYET || $act->status == AppUtils::STATUS_CHUA_HOAN_THANH
                            || $act->status == AppUtils::STATUS_TU_CHOI || $act->status == AppUtils::STATUS_VANG_MAT){
                                DB::table('nvsp_points')->insert([
                                    'id_study_year' => $studyTime->id_study_year,
                                    'id_user' => $studentId,
                                    'level' => NvspUtils::LEVEL_KHONG_DAT,
                                    'level_text' => NvspUtils::TEXT_LEVEL_KHONG_DAT,
                                    'note' => 'Không tham gia tọa đàm'
                                ]);
                                DB::table('personal_score') //Tham gia đầy đủ các buổi rèn luyện NVSP =>  không hoàn thành
                                    ->where('id_study_time', $current->id)
                                    ->where('id_user', $studentId)
                                    ->where('id_tieu_chi', TcUtils::TIEU_CHI_THAM_GIA_NVSP)
                                    ->update([
                                        'status' => AppUtils::SCORE_HOAN_THANH
                                    ]);
                                $statusFlg = false;
                                break;
                            }
                        }
                        if(!$statusFlg) continue;
                    }
                    DB::table('personal_score') //Tham gia đầy đủ các buổi rèn luyện NVSP =>  hoàn thành => có điểm
                        ->where('id_study_time', $current->id)
                        ->where('id_user', $studentId)
                        ->where('id_tieu_chi', TcUtils::TIEU_CHI_THAM_GIA_NVSP)
                        ->update([
                            'status' => AppUtils::SCORE_HOAN_THANH,
                            'score' => DB::raw('max_score'),
                        ]);
                    $user_activities = DB::table('activities_details')
                    ->join('child_activities', 'child_activities.id', 'activities_details.id_child_activity')
                    ->join('user_activities', 'user_activities.id_activities_details', 'activities_details.id')
                    ->select('user_activities.*', 'child_activities.id as id_child_activity', 'activities_details.level', 'activities_details.join_type')
                    ->where('child_activities.id_study_time', $studyTime->id)
                    ->where('child_activities.id_activity', AppUtils::HOAT_DONG_NVSP)
                    ->where('activities_details.level', '!=', AppUtils::LEVEL_TOA_DAM)
                    ->where('user_activities.id_user', $studentId)
                    ->get();
                    if(!count($user_activities)){ // không tham gia phần thi nào
                        DB::table('nvsp_points')->insert([
                            'id_study_year' => $studyTime->id_study_year,
                            'id_user' => $studentId,
                            'level' => NvspUtils::LEVEL_KHONG_DAT,
                            'level_text' => NvspUtils::TEXT_LEVEL_KHONG_DAT,
                            'note' => 'Không dự thi phần thi nào'
                        ]);
                        DB::table('personal_score') //Tham dự thi NVSP cấp khoa, trường =>  không hoàn thành
                            ->where('id_study_time', $current->id)
                            ->where('id_user', $studentId)
                            ->where('id_tieu_chi', TcUtils::TIEU_CHI_DU_THI_NVSP)
                            ->update([
                                'status' => AppUtils::SCORE_HOAN_THANH,
                            ]);
                        continue;
                    }
                    else {
                        $noJoinActs = array_filter($user_activities->toArray(), function($act){
                            $act_receive = DB::table('user_receive_activities')
                            ->where('id_user', $act->id_user)
                            ->where('id_child_activity',$act->id_child_activity)
                            ->where('child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU)
                            ->first();
                        return $act_receive->status == AppUtils::STATUS_CHO_DUYET || $act_receive->status == AppUtils::STATUS_CHUA_HOAN_THANH
                            || $act_receive->status == AppUtils::STATUS_TU_CHOI || $act_receive->status == AppUtils::STATUS_VANG_MAT;
                        });
                        if(count($noJoinActs)) {
                            DB::table('nvsp_points')->insert([  // không hoàn thành
                                'id_study_year' => $studyTime->id_study_year,
                                'id_user' => $studentId,
                                'level' => NvspUtils::LEVEL_KHONG_DAT,
                                'level_text' => NvspUtils::TEXT_LEVEL_KHONG_DAT,
                                'note' => 'Chưa hoàn thành hoặc vắng thi'
                            ]);
                            DB::table('personal_score') //Tham dự thi NVSP cấp khoa, trường =>  không hoàn thành
                            ->where('id_study_time', $current->id)
                            ->where('id_user', $studentId)
                            ->where('id_tieu_chi', TcUtils::TIEU_CHI_DU_THI_NVSP)
                            ->update([
                                'status' => AppUtils::SCORE_HOAN_THANH,
                            ]);
                            continue;
                        }
                        $schoolJoins = array_filter($user_activities->toArray(), function($act){
                            return $act->level == AppUtils::LEVEL_TRUONG; //dự thi cấp trường
                        });
                        if(count($schoolJoins)){
                            $personAwards = array_filter($schoolJoins, function($item){
                                return $item->join_type == AppUtils::THI_CA_NHAN;
                            });
                            DB::table('nvsp_points')->insert([
                                'id_study_year' => $studyTime->id_study_year,
                                'id_user' => $studentId,
                                'level' => NvspUtils::LEVEL_GIOI,
                                'level_text' => NvspUtils::TEXT_LEVEL_GIOI,
                                'note' => 'Tham gia đội thi cấp trường',
                                'join_type' => count($personAwards)  ? 'Thi cá nhân' : 'Thi theo đội',
                            ]);
                            DB::table('personal_score') //Tham dự thi NVSP cấp khoa, trường =>  hoàn thành
                                ->where('id_study_time', $current->id)
                                ->where('id_user', $studentId)
                                ->where('id_tieu_chi', TcUtils::TIEU_CHI_DU_THI_NVSP)
                                ->update([
                                    'status' => AppUtils::SCORE_HOAN_THANH,
                                    'score' => DB::raw('max_score')
                                ]);
                            continue;
                        }
                        $firstAwards = array_filter($user_activities->toArray(), function($act){
                            return $act->award == AppUtils::GIAI_NHAT; //đạt giải nhất
                        });
                        if(count($firstAwards)){
                            $personAwards = array_filter($firstAwards, function($item){
                                return $item->join_type == AppUtils::THI_CA_NHAN;
                            });
                            DB::table('nvsp_points')->insert([
                                'id_study_year' => $studyTime->id_study_year,
                                'id_user' => $studentId,
                                'level' => NvspUtils::LEVEL_GIOI,
                                'level_text' => NvspUtils::TEXT_LEVEL_GIOI,
                                'note' => 'Đạt giải Nhất cấp Khoa',
                                'join_type' => count($personAwards)  ? 'Thi cá nhân' : 'Thi theo đội',
                            ]);
                            DB::table('personal_score') //Đạt giải nhất, nhì, ba trong các cuộc thi từ cấp khoa trở lên =>  hoàn thành
                                ->where('id_study_time', $current->id)
                                ->where('id_user', $studentId)
                                ->where('id_tieu_chi', TcUtils::TIEU_CHI_GIAI_NVSP)
                                ->update([
                                    'status' => AppUtils::SCORE_HOAN_THANH,
                                    'score' => DB::raw('max_score')
                                ]);
                            continue;
                        }
                        $secondOrThirdAwards = array_filter($user_activities->toArray(), function($act){
                            return $act->award == AppUtils::GIAI_NHI || $act->award == AppUtils::GIAI_BA; //đạt giải nhì hoặc giải ba
                        });
                        if(count($secondOrThirdAwards)){
                            $personAwards = array_filter($secondOrThirdAwards, function($item){
                                return $item->join_type == AppUtils::THI_CA_NHAN;
                            });
                            DB::table('nvsp_points')->insert([
                                'id_study_year' => $studyTime->id_study_year,
                                'id_user' => $studentId,
                                'level' => NvspUtils::LEVEL_KHA,
                                'level_text' => NvspUtils::TEXT_LEVEL_KHA,
                                'note' => 'Đạt giải Ba, giải Nhì cấp Khoa',
                                'join_type' => count($personAwards)  ? 'Thi cá nhân' : 'Thi theo đội',
                            ]);
                            DB::table('personal_score') //Đạt giải nhất, nhì, ba trong các cuộc thi từ cấp khoa trở lên =>  hoàn thành
                                ->where('id_study_time', $current->id)
                                ->where('id_user', $studentId)
                                ->where('id_tieu_chi', TcUtils::TIEU_CHI_GIAI_NVSP)
                                ->update([
                                    'status' => AppUtils::SCORE_HOAN_THANH,
                                    'score' => DB::raw('max_score')
                                ]);
                            continue;
                        }
                        DB::table('nvsp_points')->insert([ // tham gia thi đầy đủ
                            'id_study_year' => $studyTime->id_study_year,
                            'id_user' => $studentId,
                            'level' => NvspUtils::LEVEL_TRUNG_BINH,
                            'level_text' => NvspUtils::TEXT_LEVEL_TRUNG_BINH,
                            'note' => 'Tham gia dự thi đầy đủ các phần thi',
                        ]);
                        DB::table('personal_score') //Tham dự thi NVSP cấp khoa, trường =>  hoàn thành
                            ->where('id_study_time', $current->id)
                            ->where('id_user', $studentId)
                            ->where('id_tieu_chi', TcUtils::TIEU_CHI_DU_THI_NVSP)
                            ->update([
                                'status' => AppUtils::SCORE_HOAN_THANH,
                                'score' => DB::raw('max_score')
                            ]);
                        DB::table('personal_score') //Đạt giải nhất, nhì, ba trong các cuộc thi từ cấp khoa trở lên => không có điểm
                            ->where('id_study_time', $current->id)
                            ->where('id_user', $studentId)
                            ->where('id_tieu_chi', TcUtils::TIEU_CHI_GIAI_NVSP)
                            ->update([
                                'status' => AppUtils::SCORE_HOAN_THANH,
                            ]);
                    }
                }
            });
            return $this->sendResponse('', __('message.success.update', ['atribute' => 'điểm rèn luyện NVSP']));
        }
        catch(\Exception $e){
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
