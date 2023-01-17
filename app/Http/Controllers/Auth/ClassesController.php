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
            return $this->sendResponse($data,__('message.success.get_list',['atribute' => 'chi Đoàn']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'chi Đoàn']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getClasses(Request $request){
        try{
            $classList = DB::table('classes')->get();
            return $this->sendResponse($classList,__('message.success.get_list',['atribute' => 'chi Đoàn']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'chi Đoàn']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $class_name = $request->get('class_name');
            $id_faculty = $request->get('id_faculty');
            $id_class_type = $request->get('id_class_type');
            $id_term = $request->get('id_term');
            DB::table('classes')->insert([
                'class_name' => $class_name,
                'id_faculty' => $id_faculty,
                'id_class_type' => $id_class_type,
                'id_term' => $id_term,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return $this->sendResponse('', __('message.success.create',['atribute' => 'chi Đoàn']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'chi Đoàn']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
