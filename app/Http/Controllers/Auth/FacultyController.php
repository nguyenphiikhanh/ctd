<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacultyController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $getAllFlg = $request->get('getAllFlg');
        try{
            $facultyList = [];
            if($getAllFlg){
                $facultyList = DB::table('faculties')->get();
            }
            else {
                $facultyList = DB::table('faculties')->get();
            }
            return $this->sendResponse($facultyList, __('message.success.get_list',['atribute' => 'khoa/ngành đào tạo']));
        }
        catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'khoa/ngành đào tạo']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $faculty_name = $request->get('faculty_name');
            DB::table('faculties')->insert([
                'faculty_name' => $faculty_name
            ]);
            return $this->sendResponse('',__('message.success.create',['atribute' => 'khoa/ngành đào tạo']));
        }
       catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'khoa/ngành đào tạo']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
