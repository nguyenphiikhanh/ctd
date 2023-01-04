<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\ChildActivity;
use App\Http\Controllers\Controller;
use App\Http\Utils\AppUtils;
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
        return view('pages.nhiemVu.index');
    }

    public function create(){
        return view('pages.nhiemVu.create');
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
            $taskName = $request->get('taskName');
            $activity = $request->get('activity');
            $action = $request->get('action');
            $details = $request->get('details');
            DB::beginTransaction();
            if($action == AppUtils::NOTIFICATION_JOIN){
                $child_activity = ChildActivity::create([
                    'id_activity' => $activity,
                    'child_activity_type' => $action,
                    'details' => $details,
                    'name' => $taskName,
                    'created_by' => $user->id,
                ]);

                DB::table('activities_details')->insert([
                    'id_child_activity' => $child_activity->id,
                    'details' => $details
                ]);
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
