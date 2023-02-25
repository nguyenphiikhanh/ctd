<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Utils\AppUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
            $user = Auth::user();
            $classList = DB::table('classes')
            ->leftJoin('class_type', 'classes.id_class_type', 'class_type.id')
            ->leftJoin('terms', 'classes.id_term', 'terms.id')
            ->select('classes.id',
            DB::raw("CONCAT(classes.class_name,'(',terms.term_name,' - ', class_type.type_name ,')') as class_name"))
            ->where('id_faculty', $user->id_khoa)
            ->where('terms.setting_flg', AppUtils::VALID_VALUE);
            $classList->orderByDesc('classes.class_name');
            $data = $classList->get();
            return $this->sendResponse($data,__('message.success.get_list',['atribute' => 'lớp']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'lớp']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getClasses(Request $request){
        try{
            $user = Auth::user();
            $classList = DB::table('classes')->where('id_faculty', $user->id_khoa)
                ->leftJoin('terms', 'terms.id', 'classes.id_term')
                ->leftJoin('class_type', 'class_type.id', 'classes.id_class_type')
                ->rightJoin('users', 'users.id_class', 'classes.id')
                ->select('classes.id','classes.class_name', 'terms.term_name', 'class_type.type_name',DB::raw("COUNT(users.id) as student_count"))
                ->where('terms.setting_flg', AppUtils::VALID_VALUE)
                ->groupBy('classes.id','classes.class_name', 'terms.term_name', 'class_type.type_name')
                ->orderBy('class_name')->get();
            return $this->sendResponse($classList,__('message.success.get_list',['atribute' => 'lớp']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'lớp']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $user = Auth::user();
            $class_name = $request->get('class_name');
            $id_class_type = $request->get('id_class_type');
            $id_term = $request->get('id_term');
            DB::table('classes')->insert([
                'class_name' => $class_name,
                'id_faculty' => $user->id_khoa,
                'id_class_type' => $id_class_type,
                'id_term' => $id_term,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return $this->sendResponse('', __('message.success.create',['atribute' => 'lớp']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'lớp']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
        try{
            $classInfo = DB::table('classes')
                ->select('classes.*','faculties.faculty_name', 'terms.term_name', 'class_type.type_name')
                ->leftJoin('faculties', 'classes.id_faculty', 'faculties.id')
                ->leftJoin('terms', 'terms.id', 'classes.id_term')
                ->leftJoin('class_type', 'class_type.id', 'classes.id_class_type')
                ->where('classes.id', $id)->first();
            if(!$classInfo){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'lớp'], Response::HTTP_UNPROCESSABLE_ENTITY));
            }
            return $this->sendResponse($classInfo,__('message.success.show',['atribute' => 'lớp']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.show', ['atribute' => 'lớp']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
