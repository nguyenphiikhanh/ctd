<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\ChildActivity;
use App\Http\Requests\UpdateChildActivityRequest;
use App\Http\Traits\UploadFileTrait;
use App\Http\Utils\AppUtils;
use App\Http\Utils\RoleUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChildActivityController extends AppBaseController
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
            $user = Auth::user();
            $id_activity = $request->get('id_activity');
            $child_activities = DB::table('child_activities')
                ->leftJoin('users', 'users.id', 'child_activities.id_user_assignee')
                ->leftJoin('activities_details', 'activities_details.id_child_activity', 'child_activities.id')
                ->select('child_activities.*', DB::raw("CONCAT(users.ho,' ',users.ten) as user_assign_name"), 'activities_details.join_type', 'activities_details.level')
                ->where('id_activity', $id_activity)
                ->orderByDesc('child_activities.created_at');
                if($user->role == RoleUtils::ROLE_PHU_TRACH_NVSP){
                    $child_activities->where('id_user_assignee', $user->id);
                }
            $child_activities = $child_activities->get();
            foreach($child_activities as $child_act){
                $child_act->files = DB::table('child_activity_files')
                    ->where('id_child_activity', $child_act->id)->get();
            }
            return $this->sendResponse($child_activities, __('message.success.get_list',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(){

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    use UploadFileTrait;
    public function store(Request $request)
    {
        //
        try{
            DB::connection('mysql')->transaction(function() use ($request){
                $user = Auth::user();
                $name = $request->get('name');
                $activity = $request->get('activity');
                $action = $request->get('action');
                $responseType = $request->get('responseType');
                $details = $request->get('details');
                $start_time = $request->get('start_time');
                $end_time = $request->get('end_time');
                $assignToClasses = $request->get('assignToClasses',[]);
                $assignToStudents = $request->get('assignToStudents',[]);
                $id_activities_details_assign = $request->get('id_activities_details_assign');
                $level = $request->get('level', AppUtils::LEVEL_KHOA);
                $join_type = $request->get('join_type', AppUtils::THI_NHOM);
                $files = $request->file('files',[]);
                $actDetail = null;
                $parChildAct = null;
                if($id_activities_details_assign){
                    $actDetail = DB::table('activities_details')->where('id', $id_activities_details_assign)->first();
                    if($actDetail){
                        $parChildAct = ChildActivity::find($actDetail->id_child_activity);
                    }
                };
                $latestStudyTime = DB::table('study_times')->latest()->first();
                $child_act = ChildActivity::create([
                    'name' => $name,
                    'id_activity' => $activity,
                    'details' => $details,
                    'start_time' => $start_time,
                    'child_activity_type' => $responseType ? $responseType : $action,
                    'end_time' => $end_time,
                    'created_by' => $user->id,
                    'created_at' => now(),
                    'id_user_assignee' => $parChildAct ? $parChildAct->id_user_assignee : $user->id,
                    'id_child_activity_assign' => $actDetail ? $actDetail->id_child_activity : null,
                    'id_study_time' => $latestStudyTime->id,
                ]);
                // phan thi or tieu ban
                $id_act_details = null;
                if($action == AppUtils::PHAN_THI_OR_TIEU_BAN){
                    $id_act_details = DB::table('activities_details')->insertGetId([
                        'id_child_activity' => $child_act->id,
                        'name' => $name,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'created_at' => now(),
                        'details' => $details,
                        'level' => $level,
                        'join_type' => $join_type
                    ]);
                    // NKCH => chọn ds thi
                    if($activity == AppUtils::HOAT_DONG_NCKH){
                        foreach($assignToStudents as $student){
                            DB::table('user_receive_activities')->insert([
                                'id_user' => $student,
                                'id_child_activity' => $child_act->id,
                                'child_activity_type' => AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU,
                                'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                                'id_activities_details_assign' => $id_activities_details_assign,
                                'created_by' => $user->id,
                                'created_at' => now()
                            ]);
                            DB::table('user_activities')->insert([
                                'id_user' => $student,
                                'id_activities_details' => $id_act_details,
                                'created_by' => $user->id,
                                'created_at' => now()
                            ]);
                        }
                    }
                    //
                }
                //khong phan hoi
                elseif($action == AppUtils::THONG_BA0_KHONG_PHAN_HOI){
                    foreach($assignToClasses as $receiveObj){
                        $user_cbl = DB::table('users')->where('role',RoleUtils::ROLE_CBL)
                            ->where('id_class', $receiveObj)->first();
                        DB::table('user_receive_activities')->insert([
                            'id_user' => $user_cbl->id,
                            'id_child_activity' => $child_act->id,
                            'child_activity_type' => $responseType ? $responseType : $action,
                            'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                            'created_by' => $user->id,
                            'created_at' => now()
                        ]);
                    }
                }
                // co phan hoi
                else{
                    foreach($assignToClasses as $receiveObj){
                        $user_cbl = DB::table('users')->where('role',RoleUtils::ROLE_CBL)
                        ->where('id_class', $receiveObj)->first();
                        DB::table('user_receive_activities')->insert([
                            'id_user' => $user_cbl->id,
                            'id_child_activity' => $child_act->id,
                            'child_activity_type' => $responseType ? $responseType : $action,
                            'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                            'id_activities_details_assign' => $id_activities_details_assign,
                            'created_by' => $user->id,
                            'created_at' => now()
                        ]);
                    }
                }
                //save file upload
                $this->storageMultipleFile($files, 'child_activity_files','id_child_activity' , $child_act->id);
            });
            return $this->sendResponse('',__('message.success.create',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            Log::error('Error while write data!');
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActivitiesReceive(){
        try{
            $user = Auth::user();
            $actRecriveList = DB::table('user_receive_activities')->where('id_user', $user->id)
                ->leftJoin('child_activities', 'child_activities.id','user_receive_activities.id_child_activity')
                ->leftJoin('activities_details', 'activities_details.id', 'user_receive_activities.id_activities_details_assign')
                ->select(
                    'user_receive_activities.*', 'child_activities.name as name',
                    'child_activities.created_at as created_at', 'child_activities.details as details',
                    'child_activities.start_time as start_time', 'child_activities.end_time as end_time',
                    'activities_details.level', 'activities_details.join_type'
                )
                ->get();
            foreach($actRecriveList as $act){
                $act->note = '';
                if($act->child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU){
                    $user_act = DB::table('user_activities')
                        ->select('user_activities.*')
                        ->join('activities_details', 'activities_details.id', 'user_activities.id_activities_details')
                        ->leftJoin('user_receive_activities','user_receive_activities.id_child_activity', 'activities_details.id_child_activity')
                        ->where('user_activities.id_user',$act->id_user)
                        ->where('user_receive_activities.id_child_activity', $act->id_child_activity)
                        ->where('user_receive_activities.child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU)
                        ->first();
                    $act->note = $user_act ? $user_act->note : '';
                }
                if($act->child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA){
                    $user_act = DB::table('user_join_activities')
                    ->select('user_join_activities.*')
                    ->join('activities_details', 'activities_details.id', 'user_join_activities.id_activities_details')
                    ->leftJoin('user_receive_activities','user_receive_activities.id_child_activity', 'activities_details.id_child_activity')
                    ->where('user_join_activities.id_user',$act->id_user)
                    ->where('user_receive_activities.id_child_activity', $act->id_child_activity)
                    ->where('user_receive_activities.child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU)
                    ->first();
                    $act->note = $user_act ? $user_act->note : '';
                }
                $attackFiles = DB::table('child_activity_files')->where('id_child_activity', $act->id_child_activity)->get();
                $act->files = $attackFiles;
            }
            return $this->sendResponse($actRecriveList,__('message.success.get_list',['atribute' => 'nhiệm vụ và thông báo']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'nhiệm vụ và thông báo']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActivityResponsiable(Request $request){
        try{
            $activity = $request->get('activity');
            $user = Auth::user();
            $childActivitiesCreated = DB::table('child_activities')
                ->join('activities_details','child_activities.id','activities_details.id_child_activity')
                ->select('activities_details.*', 'child_activities.name as name')
                ->where('child_activities.id_activity', $activity);
            if($user->role == RoleUtils::ROLE_PHU_TRACH_NVSP){
                $childActivitiesCreated->where('child_activities.id_user_assignee', $user->id);
            }
            $childActivitiesCreated = $childActivitiesCreated->get();
            return $this->sendResponse($childActivitiesCreated, __('message.success.get_list',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function forwardChildActivity(Request $request, $id){
        try{
            $user = Auth::user();
            $assignTo = $request->get('assignTo');
            $readonlyFlg = $request->get('readonlyFlg');
            $small_role_details = $request->get('small_role_details');
            $team_flg = $request->get('team_flg');
            $teams = $request->get('teams');
            DB::connection('mysql')->transaction(function() use ($user, $assignTo, $readonlyFlg, $small_role_details, $team_flg, $teams, $id){
                $notiFromCbl = DB::table('user_receive_activities')
                ->join('child_activities','child_activities.id', 'user_receive_activities.id_child_activity')
                ->select('user_receive_activities.*','child_activities.child_activity_type as child_activity_type')
                ->where('user_receive_activities.id',$id)->where('id_user', $user->id)->first();
                $action_flg = AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU;
                if($notiFromCbl->child_activity_type == AppUtils::TB_GUI_DS_THAM_GIA){
                    $action_flg = AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA;
                }
                $act_detail = DB::table('activities_details')->where('id', $notiFromCbl->id_activities_details_assign)->first();
                if($team_flg){
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
                else{
                    if($readonlyFlg){  // thông báo không phản hồi
                        foreach($assignTo as $student_id){
                            if($student_id != $user->id){  // ko cần gửi thông báo cho chính mình
                                DB::table('user_receive_activities')->insert([
                                    'created_by' => $user->id,
                                    'id_child_activity' => $notiFromCbl->id_child_activity,
                                    'child_activity_type' => AppUtils::THONG_BA0_KHONG_PHAN_HOI,
                                    'id_user' => $student_id,
                                    'small_role_details' => $small_role_details,
                                    'status' => AppUtils::STATUS_HOAN_THANH,
                                    'created_at' => now()
                                ]);
                            }
                        }
                    }
                    else{ // thông báo có phản hồi
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
                }
                DB::table('user_receive_activities')->where('id',$id)->update([
                    'status' => AppUtils::STATUS_HOAN_THANH,
                ]);
            });
            return $this->sendResponse('',__('message.success.forward'));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.forward'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActivitiesForCheckList(Request $request){
        try{
            $user = $request->user();
            // hđ # NCKH
            $activityChecklist = DB::table('user_receive_activities')
                ->join('activities_details','user_receive_activities.id_activities_details_assign', 'activities_details.id')
                ->join('child_activities','child_activities.id','user_receive_activities.id_child_activity')
                ->join('users', 'users.id', 'user_receive_activities.id_user')
                ->select('activities_details.*',
                'child_activities.id_activity','child_activities.child_activity_type as child_activity_type')
                ->orderByDesc('user_receive_activities.created_at');
            if($user->role == RoleUtils::ROLE_CBL){
                $activityChecklist->where(function($where) use($user) {
                    $where->where('user_receive_activities.id_user', $user->id)
                    ->where('user_receive_activities.status', AppUtils::STATUS_HOAN_THANH);
                });
            }
            if($user->role == RoleUtils::ROLE_LOP_TRUONG){
                $activityChecklist->where(function($query) use($user){
                $query->where('users.role', RoleUtils::ROLE_CBL)
                    ->where('users.id_class', $user->id_class)
                    ->where(function($subQuery){
                        $subQuery->where('child_activities.child_activity_type', AppUtils::TB_GUI_DS_THAM_DU)
                                ->orWhere('child_activities.child_activity_type', AppUtils::TB_GUI_DS_THAM_GIA);
                    })
                    ->where('user_receive_activities.status', AppUtils::STATUS_HOAN_THANH);
                });
            }
            $activityChecklist = $activityChecklist->get();
            //
            $act_nckhs = DB::table('activities_details')
                ->join('child_activities','child_activities.id','activities_details.id_child_activity')
                ->select('activities_details.*',
                'child_activities.id_activity','child_activities.child_activity_type as child_activity_type')
                ->where('child_activities.id_activity', AppUtils::HOAT_DONG_NCKH)
                ->get();
            foreach($act_nckhs as $act){
                $userActivitiesIds = DB::table('user_activities')
                            ->join('users','users.id', 'user_activities.id_user')
                            ->where('id_activities_details', $act->id)
                            ->where('users.id_class', $user->id_class)
                            ->get();
                if(count($userActivitiesIds)){
                    $activityChecklist[] = $act;
                }
            }
            $activityChecklist = $activityChecklist->toArray();
            usort($activityChecklist, function($a, $b){
                $aTime = strtotime($a->created_at);
                $bTime = strtotime($b->created_at);
                return $bTime - $aTime;
            });
            return $this->sendResponse($activityChecklist, __('message.success.get_list',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserForCheckList(Request $request, $activity_details_id){
        try{
            $user = Auth::user();
            $child_activity_type = $request->get('child_activity_type');
            $userChecklist = [];
            $act_detail = DB::table('activities_details')->where('id',$activity_details_id)->first();
            if($child_activity_type
            && ($child_activity_type == AppUtils::TB_GUI_DS_THAM_DU || $child_activity_type == AppUtils::PHAN_THI_OR_TIEU_BAN)){
                $userChecklist = DB::table('user_activities')
                    ->select('users.id as id',DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"),
                    'user_activities.award as award',
                    'users.username','user_activities.note', 'user_receive_activities.status')
                    ->leftJoin('activities_details','activities_details.id', 'user_activities.id_activities_details')
                    ->leftJoin('users','user_activities.id_user', 'users.id')
                    ->leftjoin('user_receive_activities','user_receive_activities.id_user','user_activities.id_user')
                    ->where('activities_details.id',$activity_details_id)
                    ->where('user_receive_activities.id_child_activity', $act_detail->id_child_activity)
                    ->where('user_receive_activities.child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU)
                    ->where('users.id_class', $user->id_class)
                    ->get();
            }
            if($child_activity_type && $child_activity_type == AppUtils::TB_GUI_DS_THAM_GIA){
                $userChecklist = DB::table('user_join_activities')
                    ->select('users.id as id',DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"),
                    'user_join_activities.note','users.username','user_receive_activities.status')
                    ->leftJoin('users','user_join_activities.id_user', 'users.id')
                    ->leftJoin('activities_details','activities_details.id', 'user_join_activities.id_activities_details')
                    ->leftjoin('user_receive_activities','user_receive_activities.id_user','user_join_activities.id_user')
                    ->where('activities_details.id',$activity_details_id)
                    ->where('user_receive_activities.id_child_activity', $act_detail->id_child_activity)
                    ->where('user_receive_activities.child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA)
                    ->where('users.id_class', $user->id_class)
                    ->get();
            }

            return $this->sendResponse($userChecklist, __('message.success.get_list',['atribute' => 'sinh viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'sinh viên']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserCheckList(Request $request ,$user_id, $activity_details_id){
        try{
            $child_activity_type = $request->get('child_activity_type');
            $status = $request->get('status');
            $note = $request->get('note');

            $act_detail = DB::table('activities_details')->where('id', $activity_details_id)->first();
            if(!$act_detail){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']));
                return;
            }
            $userUpdate = null;
            DB::connection('mysql')->transaction(function() use ($child_activity_type, $status, $note, $act_detail, $userUpdate, $user_id, $activity_details_id){
                if($child_activity_type
                && ($child_activity_type == AppUtils::TB_GUI_DS_THAM_DU || $child_activity_type == AppUtils::PHAN_THI_OR_TIEU_BAN)){
                    $userUpdate = DB::table('user_activities')
                        ->where('id_user', $user_id)
                        ->where('id_activities_details',$activity_details_id)->first();
                }
                if($child_activity_type && $child_activity_type == AppUtils::TB_GUI_DS_THAM_GIA){
                    $userUpdate = DB::table('user_join_activities')
                        ->where('id_user', $user_id)
                        ->where('id_activities_details',$activity_details_id)->first();
                }

                if(!$userUpdate){
                    return $this->sendError(__('message.failed.not_exist',['attibute' => 'Bản ghi điểm danh']),Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                else{
                    if($child_activity_type && $child_activity_type == AppUtils::TB_GUI_DS_THAM_GIA){
                        DB::table('user_join_activities')
                            ->where('id_user', $user_id)
                            ->where('id_activities_details',$activity_details_id)
                            ->update([
                                'status' => $status,
                                'note' => $note
                            ]);
                        DB::table('user_receive_activities')
                        ->where('id_user',$user_id)
                        ->where('id_child_activity', $act_detail->id_child_activity)
                        ->where('child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA)
                        ->update([
                            'status' => $status
                        ]);
                    }

                    if($child_activity_type
                    && ($child_activity_type == AppUtils::TB_GUI_DS_THAM_DU || $child_activity_type == AppUtils::PHAN_THI_OR_TIEU_BAN)){
                        DB::table('user_activities')
                            ->where('id_user', $user_id)
                            ->where('id_activities_details',$activity_details_id)
                            ->update([
                                'note' => $note
                            ]);
                        DB::table('user_receive_activities')
                        ->where('id_user',$user_id)
                        ->where('id_child_activity', $act_detail->id_child_activity)
                        ->where('child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU)
                        ->update([
                            'status' => $status
                        ]);
                    }
                    return $this->sendResponse('',__('message.success.update',['atribute' => 'điểm danh']));
                }
            });
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm danh']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //upload minh chung
    public function storeProof(Request $request){
        try {
            $user = Auth::user();
            $id = $request->id;
            $files = $request->file('files',[]);
            $id_child_activity = $request->id_child_activity;
            $child_activity_type = $request->child_activity_type;
            $act_details = DB::table('activities_details')->where('id_child_activity', $id_child_activity)->first();
            DB::connection('mysql')->transaction(function() use($user, $id, $files, $child_activity_type, $act_details, $id_child_activity){
                DB::table('user_receive_activities')
                ->where('id', $id)
                ->where('id_child_activity', $id_child_activity)
                ->where('id_user', $user->id)
                ->update([
                    'status' => AppUtils::STATUS_CHO_DUYET,
                ]);
            if($child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU){
                $user_act = DB::table('user_activities')
                    ->where('id_user', $user->id)
                    ->where('id_activities_details', $act_details->id)->first();
                $this->storageMultipleFile($files, 'user_activity_prooves', 'id_user_activities' , $user_act->id, 'act_proof');
            }
            else{
                DB::table('user_join_activities')
                ->where('id_user' ,$user->id)
                ->where('id_activities_details', $act_details->id)
                ->update([
                    'status' => AppUtils::STATUS_CHO_DUYET,
                ]);
                $user_join_act = DB::table('user_join_activities')
                    ->where('id_user', $user->id)
                    ->where('id_activities_details', $act_details->id)
                    ->first();
                    $this->storageMultipleFile($files, 'user_join_activity_prooves', 'id_user_join_activities' , $user_join_act->id, 'join_proof');
            }
            });
            return $this->sendResponse('',__('message.success.create',['atribute' => 'minh chứng']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'minh chứng']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProoves(Request $request){
        try{
            $user_id = $request->user_id;
            $activity_details_id = $request->activity_details_id;
            $child_activity_type = $request->child_activity_type;
            $prooves = [];
            $act_detail = DB::table('activities_details')->where('id', $activity_details_id)->first();
            if(!$act_detail){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if($child_activity_type == AppUtils::TB_GUI_DS_THAM_DU || $child_activity_type == AppUtils::PHAN_THI_OR_TIEU_BAN){
                $prooves = DB::table('user_activities')
                ->select('user_activity_prooves.*')
                ->rightJoin('user_activity_prooves','user_activity_prooves.id_user_activities', 'user_activities.id')
                ->where('user_activities.id_user', $user_id)
                ->where('user_activities.id_activities_details', $activity_details_id)
                ->get();
            } else{
                $prooves = DB::table('user_join_activities')
                ->select('user_join_activity_prooves.*')
                ->rightJoin('user_join_activity_prooves','user_join_activity_prooves.id_user_join_activities', 'user_join_activities.id')
                ->where('user_join_activities.id_user', $user_id)
                ->where('user_join_activities.id_activities_details', $activity_details_id)
                ->get();
            }
            return $this->sendResponse($prooves, __('message.success.get_list',['atribute' => 'minh chứng']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'minh chứng']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserActivity($id_child_act){
        try{
            $child_act = DB::table('child_activities')->where('id', $id_child_act)->first();
            if(!$child_act){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']), Response::HTTP_UNPROCESSABLE_ENTITY);
                return;
            }
            $userActs = DB::table('child_activities')
                ->join('activities_details', 'activities_details.id_child_activity', 'child_activities.id')
                ->leftJoin('user_activities','user_activities.id_activities_details', 'activities_details.id')
                ->join('users', 'user_activities.id_user', 'users.id')
                ->leftJoin('user_activities_teams','user_activities_teams.id', 'user_activities.id_user_activities_teams')
                ->leftJoin('user_receive_activities',function($leftJoin) use($id_child_act){
                    $leftJoin->on('user_receive_activities.id_child_activity', '=', 'child_activities.id');
                    $leftJoin->on('user_receive_activities.id_user', '=', 'user_activities.id_user');
                    $leftJoin->where('user_receive_activities.child_activity_type', AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU);
                })
                ->leftJoin('classes', 'users.id_class', 'classes.id')
                ->select('users.id', DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"), 'users.username',
                'classes.class_name',
                'user_receive_activities.status as status',
                'user_activities.id as id_user_activity',
                'user_activities.award as award',
                'user_activities_teams.team_name')
                ->where('child_activities.id', $id_child_act)
                ->orderBy('classes.class_name')
                ->orderBy('user_activities_teams.team_name')
                ->get();

            return $this->sendResponse($userActs, __('message.success.get_list',['atribute' => 'người dự thi']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'người dự thi']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function awardUpdate(Request $request, $id_user_act){
        try{
            $user_act = DB::table('user_activities')
                ->where('id', $id_user_act)->first();
            if(!$user_act){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']));
                return;
            }
            $award = $request->get('award', 0);
            $user_act = DB::table('user_activities')
            ->where('id', $id_user_act)
            ->update([
                'award' => $award
            ]);

            return $this->sendResponse('', __('message.success.update',['atribute' => 'giải thưởng']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'giải thưởng']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
    public function update(UpdateChildActivityRequest $request, $id)
    {
        //
        try{
            $childAct = ChildActivity::find($id);
            if(!$childAct){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']));
            }
            $start_time = $request->get('start_time');
            $end_time = $request->get('end_time');
            DB::connection('mysql')->transaction(function() use ($childAct, $start_time, $end_time){
                $childAct->update([
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ]);
                DB::table('activities_details')
                    ->where('id_child_activity', $childAct->id)
                    ->update([
                        'start_time' => $start_time,
                        'end_time' => $end_time
                    ]);
                $act_detail = DB::table('activities_details')
                    ->where('id_child_activity', $childAct->id)->first();
                DB::table('user_activities')
                    ->where('id_activities_details', $act_detail->id)
                    ->delete();
                DB::table('user_join_activities')
                    ->where('id_activities_details', $act_detail->id)
                    ->delete();
                DB::table('user_receive_activities')
                    ->where('id_activities_details_assign', $act_detail->id)
                    ->update([
                        'status' => AppUtils::STATUS_CHUA_HOAN_THANH
                    ]);
                DB::table('user_receive_activities')
                    ->where('id_child_activity', $act_detail->id_child_activity)
                    ->whereNull('id_activities_details_assign')
                    ->delete();
            });
            return $this->sendResponse('',__('message.success.update',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function changeAssigneeSetting(Request $request, $id){
        try{
            $childAct = ChildActivity::find($id);
            if(!$childAct){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'hoạt động']));
                return;
            }
            $id_user_assignee = $request->get('id_user_assignee');
            DB::table('child_activities')
                ->where('id', $childAct->id)
                ->orWhere('id_child_activity_assign', $childAct->id)
                ->update([
                    'id_user_assignee' => $id_user_assignee,
                ]);
            return $this->sendResponse('', __('message.success.update',['atribute' => 'hoạt động']));
            }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'hoạt động']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
