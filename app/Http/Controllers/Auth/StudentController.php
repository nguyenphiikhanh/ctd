<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\RoleUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentController extends AppBaseController
{
    /**
     * Display a listing of the resource.
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
            return $this->sendResponse($students,__('message.success.get_list',['atribute' => 'Đoàn viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'Đoàn viên']), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return $this->sendResponse('',__('message.success.create',['atribute' => 'Đoàn viên']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'Đoàn viên']), Response::HTTP_INTERNAL_SERVER_ERROR);
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
