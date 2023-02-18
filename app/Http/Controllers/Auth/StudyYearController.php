<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudyYearRequest;
use App\Models\StudyYear;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StudyYearController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $years = StudyYear::orderByDesc('id')->get();
            return $this->sendResponse($years, __('message.success.get_list',['atribute' => 'năm học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'năm học']), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudyYearRequest $request)
    {
        //
        try{
            $year_name = str_replace(' ', '', $request->year_name);
            StudyYear::create([
                'year_name' => $year_name,
            ]);
            return $this->sendResponse('', __('message.success.create', ['atribute' => 'năm học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.create',['atribute' => 'năm học']), Response::HTTP_INTERNAL_SERVER_ERROR);
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
    public function update(StudyYearRequest $request, $id)
    {
        //
        try{
            $year = StudyYear::find($id);
            if(!$year){
                return $this->sendError(__('message.failed.not_exist',['attibute' => 'Năm học']), Response::HTTP_UNPROCESSABLE_ENTITY);
                return;
            }
            $year_name = str_replace(' ', '', $request->year_name);
            $year->update([
                'year_name' => $year_name,
            ]);
            return $this->sendResponse('', __('message.success.update',['atribute' => 'năm học']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'năm học']), Response::HTTP_INTERNAL_SERVER_ERROR);
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
