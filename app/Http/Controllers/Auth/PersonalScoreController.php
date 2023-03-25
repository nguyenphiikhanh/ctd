<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\RequestStack;

class PersonalScoreController extends AppBaseController
{
    //
    public function index(){
        try{
            $user = Auth::user();
            $current = DB::table('study_times')->latest('id')->first();
            $data = DB::table('tieu_chi')
                ->leftJoin('personal_score', 'tieu_chi.id', 'personal_score.id_tieu_chi')
                ->select('personal_score.*','tieu_chi.name', 'tieu_chi.note')
                ->where('personal_score.id_study_time', $current->id)
                ->where('personal_score.id_user', $user->id)
                ->orderBy('personal_score.id_tieu_chi')
                ->get();
            return $this->sendResponse($data, __('message.success.get_list',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request){
        try{

        }
        catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm rèn luyện']));
        }
    }
}
