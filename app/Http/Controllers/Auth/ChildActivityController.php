<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\ChildActivity;
use App\Http\Controllers\Controller;
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
    public function index()
    {
        //

    }

    public function create(){

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
            $user = Auth::user();
            $name = $request->get('name');
            $activity = $request->get('activity');
            $action = $request->get('action');
            $responseType = $request->get('responseType');
            $details = $request->get('details');
            $start_time = $request->get('start_time');
            $end_time = $request->get('end_time');
            $assignTo = $request->get('assignTo',[]);
            $assignChildActivity = $request->get('assignChildActivity');
            $files = $request->file('files');
            Log::debug($name);
            Log::debug($files);
            DB::beginTransaction();
                $child_act = ChildActivity::create([
                    'name' => $name,
                    'id_activity' => $activity,
                    'details' => $details,
                    'start_time' => $start_time,
                    'child_activity_type' => $responseType ? $responseType : $action,
                    'end_time' => $end_time,
                    'created_by' => $user->id,
                ]);
                // phan thi or tieu ban
                if($action == AppUtils::PHAN_THI_OR_TIEU_BAN){
                    DB::table('activities_details')->insert([
                        'id_child_activity' => $child_act->id,
                        'name' => $name,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'created_at' => now(),
                        'details' => $details,
                    ]);
                }
                //khong phan hoi
                elseif($action == AppUtils::THONG_BA0_KHONG_PHAN_HOI){
                    foreach($assignTo as $receiveObj){
                        if($user->role == RoleUtils::ROLE_DOAN_TRUONG){
                            $user_cbl = DB::table('users')->where('role',RoleUtils::ROLE_CBL)
                                ->where('id_class', $receiveObj)->first();
                            DB::table('user_receive_activities')->insert([
                                'id_user' => $user_cbl->id,
                                'id_child_activity' => $child_act->id,
                                'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                                'created_by' => $user->id,
                            ]);
                        }
                    }
                }
                // co phan hoi
                else{
                    if($user->role == RoleUtils::ROLE_DOAN_TRUONG){
                        foreach($assignTo as $receiveObj){
                            $user_cbl = DB::table('users')->where('role',RoleUtils::ROLE_CBL)
                            ->where('id_class', $receiveObj)->first();
                            DB::table('user_receive_activities')->insert([
                                'id_user' => $user_cbl->id,
                                'id_child_activity' => $child_act->id,
                                'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                                'id_activities_details_assign' => $assignChildActivity,
                                'created_by' => $user->id,
                            ]);
                        }
                    }
                }
            DB::commit();
            return $this->sendResponse('',__('message.success.create',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActivitiesReceive(){
        try{
            $user = Auth::user();
            $actRecriveList = DB::table('user_receive_activities')->where('id_user', $user->id)
                ->leftJoin('child_activities', 'child_activities.id','user_receive_activities.id_child_activity')
                ->select(
                    'user_receive_activities.*', 'child_activities.name as name',
                    'child_activities.created_at as created_at','child_activities.details as details',
                    'child_activities.child_activity_type as child_activity_type'
                )
                ->get();
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
                ->where('child_activities.id_activity', $activity)
                ->get();
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
            DB::beginTransaction();
            $notiFromCbl = DB::table('user_receive_activities')
            ->join('child_activities','child_activities.id', 'user_receive_activities.id_child_activity')
            ->select('user_receive_activities.*','child_activities.child_activity_type as child_activity_type')
            ->where('user_receive_activities.id',$id)->where('id_user', $user->id)->first();
            if($readonlyFlg){  // thông báo không phản hồi
                foreach($assignTo as $student_id){
                    DB::table('user_receive_activities')->insert([
                        'created_by' => $user->id,
                        'id_child_activity' => $notiFromCbl->id_child_activity,
                        'id_user' => $student_id,
                        'small_role_details' => $small_role_details,
                        'status' => AppUtils::STATUS_HOAN_THANH,
                    ]);
                }
            }
            else{ // thông báo có phản hồi
                foreach($assignTo as $student_id){
                    if($student_id != $user->id){
                        DB::table('user_receive_activities')->insert([
                            'created_by' => $user->id,
                            'id_child_activity' => $notiFromCbl->id_child_activity,
                            'id_user' => $student_id,
                            'small_role_details' => $small_role_details,
                            'status' => AppUtils::STATUS_HOAN_THANH,
                        ]);
                    }

                    if($notiFromCbl->child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU){
                        DB::table('user_activities')->insert([
                            'id_activities_details' => $notiFromCbl->id_activities_details_assign,
                            'id_user' => $student_id,
                            'created_by' => $user->id,
                        ]);
                    } else {
                        DB::table('user_join_activities')->insert([
                            'id_activities_details' => $notiFromCbl->id_activities_details_assign,
                            'id_user' => $student_id,
                            'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                            'created_by' => $user->id,
                        ]);
                    }
                }
            }
            DB::table('user_receive_activities')->where('id',$id)->update([
                'status' => AppUtils::STATUS_HOAN_THANH,
            ]);
            DB::commit();
            return $this->sendResponse('',__('message.success.forward'));
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.forward'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActivitiesForCheckList(Request $request){
        try{
            $user = $request->user();
            $activityChecklist = DB::table('user_receive_activities')
                ->join('activities_details','user_receive_activities.id_activities_details_assign', 'activities_details.id')
                ->leftJoin('child_activities','child_activities.id','user_receive_activities.id_child_activity')
                ->select('activities_details.*','child_activities.child_activity_type as child_activity_type')
                ->where('user_receive_activities.id_user', $user->id)
                ->where('user_receive_activities.status', AppUtils::STATUS_HOAN_THANH)
                ->get();
            return $this->sendResponse($activityChecklist, __('message.success.get_list',['atribute' => 'hoạt động']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'hoạt động']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserForCheckList(Request $request, $activity_details_id){
        try{
            $child_activity_type = $request->get('child_activity_type');
            $userChecklist = [];
            if($child_activity_type && $child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU){
                $userChecklist = DB::table('user_activities')
                    ->select('users.id as id',DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"),
                    'user_activities.note as note','users.username as username','user_activities.award as status')
                    ->leftJoin('users','user_activities.id_user', 'users.id')
                    ->leftJoin('activities_details','activities_details.id', 'user_activities.id_activities_details')
                    ->where('activities_details.id',$activity_details_id)
                    ->get();
            }
            if($child_activity_type && $child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA){
                $userChecklist = DB::table('user_join_activities')
                    ->select('users.id as id',DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"),
                    'user_join_activities.note as note','users.username as username','user_join_activities.status as status')
                    ->leftJoin('users','user_join_activities.id_user', 'users.id')
                    ->leftJoin('activities_details','activities_details.id', 'user_join_activities.id_activities_details')
                    ->where('activities_details.id',$activity_details_id)
                    ->get();
            }

            return $this->sendResponse($userChecklist, __('message.success.get_list',['atribute' => 'Đoàn viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'Đoàn viên']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserCheckList(Request $request ,$user_id, $activity_details_id){
        try{
            $child_activity_type = $request->get('child_activity_type');
            $status = $request->get('status');
            $note = $request->get('note');

            $userUpdate = null;
            if($child_activity_type && $child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU){
                $userUpdate = DB::table('user_activities')
                    ->where('id_user', $user_id)
                    ->where('id_activities_details',$activity_details_id)->first();
            }
            if($child_activity_type && $child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA){
                $userUpdate = DB::table('user_join_activities')
                    ->where('id_user', $user_id)
                    ->where('id_activities_details',$activity_details_id)->first();
            }

            if(!$userUpdate){
                return $this->sendError(__('message.failed.not_exist',['Bản ghi điểm danh']),Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            else{
                if($child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_GIA){
                    $userUpdate = DB::table('user_join_activities')
                    ->where('id_user', $user_id)
                    ->where('id_activities_details',$activity_details_id)
                    ->update([
                        'status' => $status,
                        'note' => $note
                    ]);
                }

                if($child_activity_type && $child_activity_type == AppUtils::THONG_BAO_C0_PHAN_HOI_THAM_DU){

                }

                return $this->sendResponse('',__('message.success.update',['atribute' => 'điểm danh']));
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm danh']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
