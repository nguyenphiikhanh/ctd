<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassTypeController extends AppBaseController
{
    //
    public function index(Request $request){
        try{
            $class_type_list = DB::table('class_type')->get();
            return $this->sendResponse($class_type_list,__('message.success.get_list',['atribute' => 'khối đào tạo']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'khối đào tạo']),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
