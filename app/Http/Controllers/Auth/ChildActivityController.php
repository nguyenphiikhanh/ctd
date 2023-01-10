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
            $details = $request->get('details');
            $start_time = $request->get('start_time');
            $end_time = $request->get('end_time');
            $assignTo = $request->get('assignTo',[]);
            DB::beginTransaction();
                $child_act = ChildActivity::create([
                    'name' => $name,
                    'id_activity' => $activity,
                    'details' => $details,
                    'start_time' => $start_time,
                    'child_activity_type' => $action,
                    'end_time' => $end_time,
                    'created_by' => $user->id,
                ]);
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
                elseif($action == AppUtils::THONG_BA0_KHONG_PHAN_HOI){
                    Log::debug('aaaa');
                    foreach($assignTo as $receiveObj){
                        Log::debug("role log: ". $user->role);
                        if($user->role == RoleUtils::ROLE_DOAN_TRUONG){
                            $user_cbl = DB::table('users')->where('role',RoleUtils::ROLE_CBL)
                                ->where('id_class', $receiveObj)->first();
                                // Log::debug($user_cbl);
                            DB::table('user_receive_activities')->insert([
                                'id_user' => $user_cbl->id,
                                'id_child_activity' => $child_act->id,
                                'status' => AppUtils::STATUS_CHUA_HOAN_THANH,
                                'created_by' => $user->id,
                            ]);
                        }
                    }
                }
                else{

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
