<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TermController extends AppBaseController
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
            $getAllFlg = $request->get('getAllFlg');
            $termList = DB::table('terms')
                    ->join('classes', 'classes.id_term', 'terms.id')
                    ->join('users', 'users.id_class', 'classes.id')
                    ->select('terms.setting_flg' ,'terms.id', 'terms.term_name', DB::raw("COUNT(users.id) as student_count"))
                    ->groupBy('terms.id', 'terms.term_name','terms.setting_flg');
            if($getAllFlg){
                $termList = $termList->get();
            }
            else{
                $termList = $termList->get();
            }
            return $this->sendResponse($termList, __('message.success.get_list',['atribute' => 'khóa đào tạo']));
        }
        catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'khóa đào tạo']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TermRequest $request)
    {
        //
        try{
            $term_name = $request->get('term_name');
            DB::table('terms')->insert([
                'term_name' => $term_name
            ]);
            return $this->sendResponse('',__('message.success.create',['atribute' => 'khóa đào tạo']));
        }
       catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'khóa đào tạo']),Response::HTTP_INTERNAL_SERVER_ERROR);
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
        try{
            $term = Term::find($id);
            if(!$term){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Khóa đào tạo']), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $term_name = $request->input('term_name');
            $setting_flg = $request->setting_flg;
            $term->update([
                'term_name' => $term_name,
                'setting_flg' => $setting_flg
            ]);
            return $this->sendResponse('',__('message.success.update',['atribute' => 'Khóa đào tạo']));
        }
        catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'khóa đào tạo']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
