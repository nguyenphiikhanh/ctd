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
            $userList = [];
            if($child_activity_type = AppUtils::TB_GUI_DS_THAM_DU){
                $userList = DB::table('user_activities')
                    ->select('users.*')
                    ->join('users', 'user_activities.id_user','users.id')
                    ->where('users.id_class', $user->id_class)
                    ->where('user_activities.id_activities_details', $id)
                    ->get();
            }
            else{
                if($child_activity_type = AppUtils::TB_GUI_DS_THAM_DU){
                    $userList = DB::table('user_join_activities')
                        ->select('users.*')
                        ->join('users', 'user_join_activities.id_user','users.id')
                        ->where('users.id_class', $user->id_class)
                        ->where('user_join_activities.id_activities_details', $id)
                        ->get();
                }
            }
            return $this->sendResponse($userList, __('message.success.get_list',['atribute' => 'người dự thi hoặc có mặt']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'người dự thi hoặc có mặt']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
