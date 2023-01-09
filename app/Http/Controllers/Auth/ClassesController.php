<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\RoleUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassesController extends AppBaseController
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
            $className = $request->get('className');
            $classList = DB::table('classes')
            ->leftJoin('faculties', 'classes.id_faculty', 'faculties.id')
            ->leftJoin('class_type', 'classes.id_class_type', 'class_type.id')
            ->leftJoin('terms', 'classes.id_term', 'terms.id')
            ->select('classes.id',DB::raw("CONCAT(classes.class_name,'(',class_type.type_name,', ', terms.term_name,' - ', faculties.faculty_name,')') as class_name"));
            if($className){
                $classList->where('class_name', 'like', "%".$className."%")
                ->orWhere('faculties.faculty_name', 'like', "%".$className."%")
                ->orWhere('class_type.type_name', 'like', "%".$className."%")
                ->orWhere('terms.term_name', 'like', "%".$className."%");
            }
            $classList->orderByDesc('faculties.id');
            $data = $classList->get();
            return $this->sendResponse($data,__('message.success.get_list',['atribute' => 'lớp']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'class']),Response::HTTP_INTERNAL_SERVER_ERROR);
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

    public function getClassByCbKhoa(Request $request){
        try{
            $user = $request->user();
            $classList = DB::table('classes')
            ->select('classes.*','users.id as id_user_cbl')
            ->join('users','users.id_class','classes.id','full outer')
            ->where('classes.id_faculty',$user->id_khoa)
            ->where('users.role', RoleUtils::ROLE_CBL)
            ->get();
            Log::debug($classList);
            return $this->sendResponse($classList,'sucess');
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'class']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
