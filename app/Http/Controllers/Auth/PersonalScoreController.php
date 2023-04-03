<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Traits\UploadFileTrait;
use App\Http\Utils\AppUtils;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\RoleUtils;
use App\Http\Utils\TcUtils;
use App\Models\PersonalScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonalScoreController extends AppBaseController
{
    //
    public function index(){
        try{
            $user = Auth::user();
            $current = DB::table('study_times')->latest('id')->first();
            $data = PersonalScore::query()
                ->rightJoin('tieu_chi', 'tieu_chi.id', 'personal_score.id_tieu_chi')
                ->select('personal_score.*','tieu_chi.name', 'tieu_chi.note')
                ->where('personal_score.id_study_time', $current->id)
                ->where('personal_score.id_user', $user->id)
                ->orderBy('personal_score.id_tieu_chi')
                ->get();
            foreach($data as $field){
                $field->score = (float) $field->score;
                $field->max_score = (float) $field->max_score;
                $field->status = (int) $field->status;
                $field->id_study_time = (int) $field->id_study_time;
                $field->id_tieu_chi = (int) $field->id_tieu_chi;
                $field->id_user = (int) $field->id_user;
            }
            return $this->sendResponse($data, __('message.success.get_list',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    use UploadFileTrait;
    public function sendProof(Request $request){
        try{
            $id = $request->get('id');
            $files = $request->file('files', []);
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
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'minh chứng']));
        }
    }

    public function getTcProoves(){
        try{
            $user = Auth::user();
            $listTc = DB::table('tieu_chi')
                ->whereIn('id', TcUtils::TIEU_CHI_UPLOADS)
                ->orderBy('id')
                ->get();
            $current = DB::table('study_times')->latest('id')->first();
            foreach($listTc as $tc){
                $waitListCount = PersonalScore::query()
                    ->leftJoin('users', 'users.id', 'personal_score.id_user')
                    ->where('id_study_time', $current->id)
                    ->where('id_tieu_chi', $tc->id)
                    ->where('status', AppUtils::SCORE_CHO_DUYET)
                    ->where('users.role', '!=' , $user->role == RoleUtils::ROLE_CBL ? RoleUtils::ROLE_CBL : RoleUtils::ROLE_LOP_TRUONG)
                    ->where('users.id_class', $user->id_class)
                    ->count();
                $tc->wait_count =  $waitListCount;
                $tc->max_score = (float) $tc->max_score;
            }
            return $this->sendResponse($listTc, __('message.success.get_list',['atribute' => 'tiêu chí']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'tiêu chí']));
        }
    }

    public function getListUserConfirm($id){
        try{
            $user = Auth::user();
            $current = DB::table('study_times')->latest('id')->first();
            $listUserCf = DB::table('personal_score')
            ->leftJoin('users', 'users.id', 'personal_score.id_user')
            ->select('personal_score.*','users.username', DB::raw("CONCAT(users.ho,' ',users.ten) as fullname"))
            ->where('id_study_time', $current->id)
            ->where('id_tieu_chi', $id)
            ->where('status', AppUtils::SCORE_CHO_DUYET)
            ->where('users.role', '!=' , $user->role == RoleUtils::ROLE_CBL ? RoleUtils::ROLE_CBL : RoleUtils::ROLE_LOP_TRUONG)
            ->where('users.id_class', $user->id_class)
            ->get();
            foreach($listUserCf as $user){
                $prooves = DB::table('personal_score_prooves')->where('id_personal_score', $user->id)->get();
                $user->prooves = $prooves;
            }
            return $this->sendResponse($listUserCf, __('message.success.get_list',['atribute' => 'tiêu chí']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'tiêu chí']));
        }
    }

    public function confirmTcProoves(Request $request, $id){
        try{
            $status = $request->get('status');
            if($status == AppUtils::SCORE_DUYET){
                DB::table('personal_score')
                    ->where('id', $id)
                    ->update([
                        'score' => DB::raw('max_score'),
                        'status' => AppUtils::SCORE_DUYET
                    ]);
            } else{
                DB::table('personal_score')
                ->where('id', $id)
                ->update([
                    'status' => AppUtils::SCORE_KHONG_DUYET
                ]);
            }
            return $this->sendResponse('', __('message.success.update', ['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.update',['atribute' => 'điểm rèn luyện']));
        }
    }

    public function getStudentPersonalScore($id_student, $id_study_time){
        try{
            $data = PersonalScore::query()
                ->rightJoin('tieu_chi', 'tieu_chi.id', 'personal_score.id_tieu_chi')
                ->select('personal_score.*','tieu_chi.name', 'tieu_chi.note')
                ->where('personal_score.id_study_time', $id_study_time)
                ->where('personal_score.id_user', $id_student)
                ->orderBy('personal_score.id_tieu_chi')
                ->get();
            foreach($data as $field){
                $field->prooves = [];
                if(in_array($field->id_tieu_chi, (array) TcUtils::TIEU_CHI_UPLOADS)){
                    $prooves = DB::table('personal_score_prooves')
                        ->where('id_personal_score', $field->id)
                        ->get();
                    $field->prooves = $prooves;
                }
                $field->score = (float) $field->score;
                $field->max_score = (float) $field->max_score;
                $field->status = (int) $field->status;
                $field->id_study_time = (int) $field->id_study_time;
                $field->id_tieu_chi = (int) $field->id_tieu_chi;
                $field->id_user = (int) $field->id_user;
            }
            return $this->sendResponse($data, __('message.success.get_list',['atribute' => 'điểm rèn luyện']));
        }
        catch(\Exception $e){
            Log::error($e->getMessage(). $e->getTraceAsString());
            return $this->sendError(__('message.failed.get_list',['atribute' => 'điểm rèn luyện']), ResponseUtils::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
