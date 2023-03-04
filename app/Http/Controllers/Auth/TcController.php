<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\TcUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TcController extends AppBaseController
{
    //
    public function getTcSelf(){
        try{
            $tcIds = TcUtils::TIEU_CHI_HOP_XET_IDS;
            $listTieuChi = DB::table('tieu_chi')
                ->whereIn('id', $tcIds)
                ->orderBy('id')
                ->get();
            return $this->sendResponse($listTieuChi, __('message.success.get_list',['atribute' => 'tiêu chí']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'tiêu chí']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
