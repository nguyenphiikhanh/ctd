<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Traits\UploadFileTrait;
use App\Http\Utils\AppUtils;
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

    use UploadFileTrait;
    public function sendProof(Request $request){
        try{
            $id = $request->get('id');
            $files = $request->file('files', []);
            Log::debug($files);
            DB::connection('mysql')->transaction(function () use($id, $files){
                if($id){
                    DB::table('personal_score')
                        ->where('id', $id)
                        ->update([
                            'status' => AppUtils::SCORE_CHO_DUYET
                        ]);
                    $this->storageMultipleFile($files, 'personal_score_prooves', 'id_personal_score', $id, 'personal_score_prooves');
                }
            });
            return $this->sendResponse('', __('message.success.update',['atribute' => 'minh chứng']));
        }
        catch(\Exception $e){
            Log::debug($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'minh chứng']));
        }
    }
}
