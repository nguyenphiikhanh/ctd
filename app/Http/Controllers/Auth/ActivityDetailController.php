<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActivityDetailController extends AppBaseController
{
    //
    public function getUser(Request $request, $id){
        $user = Auth::user();
        try{
            $actDetails = DB::table('activities_details')->where('id', $id)->first();
            if(!$actDetails){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']));
                return;
            }
            $child_activity_type = $request->get('child_activity_type');
            $team_flg = $request->get('team_flg');
            $userList = [];
            if($child_activity_type == AppUtils::TB_GUI_DS_THAM_DU){
                if($team_flg){ // thi đội
                    $teams = DB::table('user_activities_teams')
                            ->where('id_activities_details', $id)
                            ->where('id_class', $user->id_class)
                            ->orderBy('id')->get();
                    foreach($teams as $team){
                        $members = DB::table('user_activities')
                                ->join('users','users.id', 'user_activities.id_user')
                                ->select('users.*')
                                ->where('user_activities.id_user_activities_teams', $team->id)
                                ->get();
                        $team->members = $members;
                    }
                    $userList = $teams;
                }
                else{ // thi cá nhân
                    $userList = DB::table('user_activities')
                    ->select('users.*')
                    ->join('users', 'user_activities.id_user','users.id')
                    ->where('users.id_class', $user->id_class)
                    ->where('user_activities.id_activities_details', $id)
                    ->get();
                }
            }
            else{
                $userList = DB::table('user_join_activities')
                    ->select('users.*')
                    ->join('users', 'user_join_activities.id_user','users.id')
                    ->where('users.id_class', $user->id_class)
                    ->where('user_join_activities.id_activities_details', $id)
                    ->get();
            }
            return $this->sendResponse($userList, __('message.success.get_list',['atribute' => 'người dự thi hoặc có mặt']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'người dự thi hoặc có mặt']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUser(Request $request, $id){
        $user = Auth::user();
        try{
            $user = Auth::user();
            $assignTo = $request->get('assignTo');
            $small_role_details = $request->get('small_role_details');
            $team_flg = $request->get('team_flg');
            $teams = $request->get('teams');
            DB::connection('mysql')->transaction(function() use ($user, $assignTo, $small_role_details, $team_flg, $teams, $id){
                $notiFromCbl = DB::table('user_receive_activities')
                ->join('child_activities','child_activities.id', 'user_receive_activities.id_child_activity')
                ->select('user_receive_activities.*','child_activities.child_activity_type as child_activity_type')
                ->where('user_receive_activities.id',$id)->where('id_user', $user->id)->first();
                $act_detail = DB::table('activities_details')->where('id', $notiFromCbl->id_activities_details_assign)->first();
                $action_flg = AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU;
                if($notiFromCbl->child_activity_type == AppUtils::TB_GUI_DS_THAM_GIA){
                    $action_flg = AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA;
                    DB::table('user_join_activities')  // xoá ds tham dự có mặt cũ
                    ->leftJoin('users','users.id','user_join_activities.id_user')
                    ->where('users.id_class', $user->id_class)
                    ->where('user_join_activities.id_activities_details', $notiFromCbl->id_activities_details_assign)
                    ->delete();
                } else {
                    DB::table('user_activities')
                    ->leftJoin('users','users.id','user_activities.id_user')
                    ->where('users.id_class', $user->id_class)
                    ->where('user_activities.id_activities_details', $notiFromCbl->id_activities_details_assign)
                    ->delete();
                }
                //delete exist data
                DB::table('user_receive_activities')
                    ->leftJoin('users','users.id','user_receive_activities.id_user')
                    ->where('users.id_class', $user->id_class)
                    ->where('id_child_activity', $act_detail->id_child_activity)
                    ->delete();
                if($team_flg){  // thi nhóm
                    DB::table('user_activities_teams')
                        ->where('id_class', $user->id_class)
                        ->where('id_activities_details', $notiFromCbl->id_activities_details_assign)
                        ->delete();
                    foreach($teams as $team){
                        $teamId = DB::table('user_activities_teams')->insertGetId([
                            'id_activities_details' => $notiFromCbl->id_activities_details_assign,
                            'team_name' => $team['team_name'],
                            'id_class' => $user->id_class,
                        ]);
                        foreach($team['members'] as $member){
                            DB::table('user_activities')->insert([
                                'id_activities_details' => $notiFromCbl->id_activities_details_assign,
                                'id_user' => $member['id'],
                                'created_by' => $user->id,
                                'created_at' => now(),
                                'id_user_activities_teams' => $teamId
                            ]);

                            DB::table('user_receive_activities')->insert([
                                'created_by' => $user->id,
                                'id_child_activity' => $act_detail->id_child_activity,
                                'child_activity_type' => $action_flg,
                                'id_user' => $member['id'],
                                'small_role_details' => $small_role_details,
                                'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                                'created_at' => now()
                            ]);
                        }
                    }
                }
                else{ // thi cá nhân
                    foreach($assignTo as $student_id){
                        DB::table('user_receive_activities')->insert([
                            'created_by' => $user->id,
                            'id_child_activity' => $act_detail->id_child_activity,
                            'child_activity_type' => $action_flg,
                            'id_user' => $student_id,
                            'small_role_details' => $small_role_details,
                            'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                            'created_at' => now()
                        ]);

                        if($notiFromCbl->child_activity_type == AppUtils::TB_GUI_DS_THAM_DU){
                            DB::table('user_activities')->insert([
                                'id_activities_details' => $act_detail->id,
                                'id_user' => $student_id,
                                'created_by' => $user->id,
                                'created_at' => now()
                            ]);
                        } else {
                            DB::table('user_join_activities')->insert([
                                'id_activities_details' => $notiFromCbl->id_activities_details_assign,
                                'id_user' => $student_id,
                                'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                                'created_by' => $user->id,
                                'created_at' => now()
                            ]);
                        }
                    }
                }
                DB::table('user_receive_activities')->where('id',$id)->update([
                    'status' => AppUtils::STATUS_HOAN_THANH,
                ]);
            });
            return $this->sendResponse('',__('message.success.update', ['atribute' => 'danh sách']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'danh sách']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
