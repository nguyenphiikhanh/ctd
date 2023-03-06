<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\AssigneeRequest;
use App\Http\Requests\CvhtRequest;
use App\Http\Utils\RoleUtils;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends AppBaseController
{

    public function getInfo(){
        $user = Auth::user();
        return $this->sendResponse($user,Response::HTTP_OK);
    }

    public function getUserAssigneeActivities(){
        try{
            $user = Auth::user();
            $assignees = DB::table('users')
                ->select('id','username', 'email', 'ho', 'ten')
                ->where('role', RoleUtils::ROLE_PHU_TRACH_NVSP)
                ->where('id_khoa', $user->id_khoa)
                ->get();
            return $this->sendResponse($assignees, __('message.success.get_list',['atribute' => 'phụ trách viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'phụ trách viên']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeUserAssignActivities(AssigneeRequest $request){
        try{
            $user = Auth::user();
            $ho = $request->get('ho');
            $ten = $request->get('ten');
            $username = $request->get('username');
            $email = $request->get('email');
            $password = $request->get('password');

            DB::table('users')->insert([
                'username' => $username,
                'password' => Hash::make($password),
                'id_khoa' => $user->id_khoa,
                'email' => $email,
                'ho' => $ho,
                'ten' => $ten,
                'role' => RoleUtils::ROLE_PHU_TRACH_NVSP,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $this->sendResponse('', __('message.success.create',['atribute' => 'phụ trách viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'phụ trách']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserAssignActivities(AssigneeRequest $request, $id){
        try{
            $assignee = User::find($id);
            if(!$assignee){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'phụ trách viên']), Response::HTTP_UNPROCESSABLE_ENTITY);
                return;
            }

            $ho = $request->get('ho');
            $ten = $request->get('ten');
            $username = $request->get('username');
            $email = $request->get('email');

            $assignee->update([
                'username' => $username,
                'email' => $email,
                'ho' => $ho,
                'ten' => $ten,
            ]);

            return $this->sendResponse('', __('message.success.create',['atribute' => 'phụ trách viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'phụ trách']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserCvht(){
        try{
            $user = Auth::user();
            $assignees = DB::table('users')
                ->select('id','username', 'email', 'ho', 'ten')
                ->where('role', RoleUtils::ROLE_CVHT)
                ->where('id_khoa', $user->id_khoa)
                ->get();
            return $this->sendResponse($assignees, __('message.success.get_list',['atribute' => 'cố vấn học tập']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'cố vấn học tập']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeUserCvht(CvhtRequest $request){
        try{
            $user = Auth::user();
            $ho = $request->get('ho');
            $ten = $request->get('ten');
            $username = $request->get('username');
            $email = $request->get('email');
            $password = $request->get('password');

            DB::table('users')->insert([
                'username' => $username,
                'password' => Hash::make($password),
                'id_khoa' => $user->id_khoa,
                'email' => $email,
                'ho' => $ho,
                'ten' => $ten,
                'role' => RoleUtils::ROLE_CVHT,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $this->sendResponse('', __('message.success.create',['atribute' => 'cố vấn học tập']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'cố vấn học tập']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserCvht(CvhtRequest $request, $id){
        try{
            $assignee = User::find($id);
            if(!$assignee){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'cố vấn học tập']), Response::HTTP_UNPROCESSABLE_ENTITY);
                return;
            }

            $ho = $request->get('ho');
            $ten = $request->get('ten');
            $username = $request->get('username');
            $email = $request->get('email');

            $assignee->update([
                'username' => $username,
                'email' => $email,
                'ho' => $ho,
                'ten' => $ten,
            ]);

            return $this->sendResponse('', __('message.success.create',['atribute' => 'cố vấn học tập']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'cố vấn học tập']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
