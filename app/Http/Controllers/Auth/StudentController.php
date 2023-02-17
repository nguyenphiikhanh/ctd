<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
use App\Http\Utils\RoleUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $class_id)
    {
        //
        try{
            $students = DB::table('users')
                ->where('id_class', $class_id)
                ->select('id','ho','ten', 'email', 'username', 'role')
                ->get();
            return $this->sendResponse($students,__('message.success.get_list',['atribute' => 'sinh viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'sinh viên']), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $ho = $request->get('ho');
            $ten = $request->get('ten');
            $id_class = $request->get('id_class');
            $username = $request->get('username');
            $email = $request->get('email');
            $password = $request->get('password');

            DB::table('users')->insert([
                'username' => $username,
                'password' => Hash::make($password),
                'id_class' => $id_class,
                'email' => $email,
                'ho' => $ho,
                'ten' => $ten,
                'role' => RoleUtils::ROLE_SINHVIEN,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return $this->sendResponse('',__('message.success.create',['atribute' => 'Sinh viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'Sinh viên']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getStudentbyCanbolop(Request $request){
        try{
            $user = Auth::user();
            $readonlyFlg = $request->get('readonly');
            $id_activities_details_assign = $request->get('id_activities_details_assign');
            $userList = DB::table('users')
                ->select('id','ho','ten','username')
                ->where('id_class', $user->id_class);
            if($readonlyFlg){
                $userList->where('id', '!=', $user->id);
                $userList = $userList->get();
                foreach($userList as $userChoose){
                    $userChoose->chooseFlg = true;
                }
            }
            else{
                $act_detail = DB::table('activities_details')
                    ->where('id', $id_activities_details_assign)
                    ->first();
                if(!$act_detail){
                    return $this->sendError(__('message.failed.not_exist',['attibute' => 'Hoạt động']), Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                $userActIds = DB::table('activities_details')
                    ->rightJoin('user_activities','activities_details.id', 'user_activities.id_activities_details')
                    ->whereRaw("start_time <= ? AND end_time >= ?",[$act_detail->end_time, $act_detail->start_time])
                    ->select('user_activities.*', 'activities_details.name')
                    ->pluck('id_user');
                $userJoinActIds = DB::table('activities_details')
                    ->rightJoin('user_join_activities','activities_details.id', 'user_join_activities.id_activities_details')
                    ->whereRaw("start_time <= ? AND end_time >= ?",[$act_detail->end_time, $act_detail->start_time])
                    ->select('user_join_activities.*', 'activities_details.name')
                    ->pluck('id_user');
                $userIdsCheck = array_merge($userActIds->toArray(), $userJoinActIds->toArray());
                $userList = $userList->get();
                foreach($userList as $userChoose){
                    //check thi
                    $userChoose->chooseFlg = true;
                    if(in_array($userChoose->id, $userIdsCheck)){
                        $userChoose->chooseFlg = false;
                    }
                }
            }
            return $this->sendResponse($userList,__('message.success.get_list',['atribute' => 'sinh viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'sinh viên']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getStudentByFaculty(Request $request, $id_faculty){
        try{
            $start_time = $request->get('start_time');
            $end_time = $request->get('end_time');
            $userIdsCheck = [];
            if($start_time && $end_time){
            $userActIds = DB::table('activities_details')
                ->rightJoin('user_activities','activities_details.id', 'user_activities.id_activities_details')
                ->whereRaw("start_time <= ? AND end_time >= ?",[$end_time, $start_time])
                ->select('user_activities.*', 'activities_details.name')
                ->pluck('id_user');
            $userJoinActIds = DB::table('activities_details')
                ->rightJoin('user_join_activities','activities_details.id', 'user_join_activities.id_activities_details')
                ->whereRaw("start_time <= ? AND end_time >= ?",[$end_time, $start_time])
                ->select('user_join_activities.*', 'activities_details.name')
                ->pluck('id_user');
            $userIdsCheck = array_merge($userActIds->toArray(), $userJoinActIds->toArray());
            }
            $userIdsCheck = count($userIdsCheck) > 0 ? implode(',',$userIdsCheck) : 'null';
            $studentList = DB::table('users')
                ->select('users.id as id',
                    DB::raw("CONCAT(users.ho, ' ', users.ten, ' - ', users.username,
                ' (',classes.class_name,' - ', class_type.type_name,')') as name"),
                    DB::raw("CASE
                                WHEN users.id in (".$userIdsCheck.") THEN false
                                ELSE true
                             END as chooseFlg")
                )
                ->leftJoin('classes', 'classes.id', 'users.id_class')
                ->leftJoin('class_type', 'classes.id_class_type', 'class_type.id')
                ->leftJoin('terms','terms.id', 'classes.id_term')
                ->where('terms.setting_flg', AppUtils::VALID_VALUE)
                ->where('classes.id_faculty', $id_faculty)
                ->where(function($query){
                    $query->where('users.role', RoleUtils::ROLE_SINHVIEN)
                        ->orWhere('users.role', RoleUtils::ROLE_CBL)
                        ->orWhere('users.role', RoleUtils::ROLE_LOP_TRUONG);
                });
                $studentList->orderByDesc('classes.class_name');
                $data = $studentList->get();
                return $this->sendResponse($data,__('message.success.get_list',['atribute' => 'sinh viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'sinh viên']), Response::HTTP_INTERNAL_SERVER_ERROR);
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

    public function updateCbSetting(Request $request){
        try{
            $bt_id = $request->get('btId');
            $lt_id = $request->get('ltId');
            $btChange = $request->get('btChange');
            $id_class = $request->get('id_class');
            DB::connection('mysql')->transaction(function () use ($bt_id, $lt_id, $btChange, $id_class){
                if($btChange){
                    DB::table('users')->where('id_class', $id_class)
                    ->where('role', RoleUtils::ROLE_CBL)
                    ->update([
                        'role' => RoleUtils::ROLE_SINHVIEN
                    ]);
                    DB::table('users')->where('id', $bt_id)->update([
                        'role' => RoleUtils::ROLE_CBL,
                    ]);
                }
                else {
                    DB::table('users')->where('id_class', $id_class)
                    ->where('role', RoleUtils::ROLE_LOP_TRUONG)
                    ->update([
                        'role' => RoleUtils::ROLE_SINHVIEN
                    ]);
                    DB::table('users')->where('id', $lt_id)->update([
                        'role' => RoleUtils::ROLE_LOP_TRUONG,
                    ]);
                }
            });
            return $this->sendResponse('',__('message.success.update',['atribute' => 'cán bộ lớp']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'cán bộ lớp']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
