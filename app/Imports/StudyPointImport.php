<?php

namespace App\Imports;

use App\Http\Utils\AppUtils;
use App\Http\Utils\TcUtils;
use App\Models\StudyTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class StudyPointImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        try{
            $last_study_time = StudyTime::latest('id')->first();
            DB::connection('mysql')->transaction(function() use ($last_study_time, $rows){
                foreach ($rows as $row) {
                    $import = [];
                    $username = $row['ma_sinh_vien'];
                    $user = DB::table('users')->where('username', (string) $username)->first();
                    if(!$user) continue; // skip student not exist
                    $import['id_user'] = $user->id;
                    $import['id_study_time'] = $last_study_time->id;
                    $import['ten_level_avg'] = $row['tbc_ht10'];
                    $import['four_level_avg'] = $row['tbc_ht4'];
                    $import['ten_level_evaluate'] = $row['xep_loai_thang_10'] ?? 'Không xếp loại';
                    $import['four_level_evaluate'] = $row['xep_loai_thang_4'] ?? 'Không xếp loại';
                    $import['credit_in_debt'] = $row['so_tin_chi_no'];
                    $import['object_in_debt'] = $row['so_hp_no'];
                    $import['tong_so_tin_dang_ky'] = $row['tong_so_tin_dang_ky'];
                    DB::table('study_points')->updateOrInsert(
                        ['id_user' => $import['id_user'], 'id_study_time' => $import['id_study_time']],
                        $import
                    );
                    $score = 1.5;
                    if($import['tong_so_tin_dang_ky'] != 0 && $import['credit_in_debt'] != 0){
                        $reExamPercent = $import['credit_in_debt'] / $import['tong_so_tin_dang_ky'] * 100;
                        if($reExamPercent < 10){  // số tín chỉ thi lại < 10%
                            $score = 1;
                        }elseif($reExamPercent >= 10 && $reExamPercent < 20){ // số tín chỉ thi lại < 20%
                            $score = 0.5;
                        } elseif($reExamPercent >= 20){ // số tín chỉ thi lại từ 20% trở
                            $score = 0;
                        }
                    } elseif($import['tong_so_tin_dang_ky'] == 0 || $import['four_level_avg'] == 0){ // bỏ học
                        $score = 0;
                    }
                    DB::table('personal_score') //update điểm tiêu chí thi lại(8)
                        ->where('id_study_time', $last_study_time->id)
                        ->where('id_user', $user->id)
                        ->where('id_tieu_chi', TcUtils::TIEU_CHI_THI_LAI)
                        ->update([
                            'status' => AppUtils::SCORE_HOAN_THANH,
                            'score' => $score,
                        ]);
                    $tbc_score = 2.5;
                    if($import['four_level_avg'] >= 3.2 && $import['four_level_avg'] <= 3.59){ // điểm TBC
                        $tbc_score = 1.5;
                    } elseif($import['four_level_avg'] >= 2.5 && $import['four_level_avg'] <= 3.19){
                        $tbc_score = 1;
                    } elseif($import['four_level_avg'] < 2.5){
                        $tbc_score = 0;
                    }
                    DB::table('personal_score') //update điểm tiêu chí TBC (13)
                    ->where('id_study_time', $last_study_time->id)
                    ->where('id_user', $user->id)
                    ->where('id_tieu_chi', TcUtils::TIEU_CHI_TBC)
                    ->update([
                        'status' => AppUtils::SCORE_HOAN_THANH,
                        'score' => $tbc_score,
                    ]);
                }
                return true;
            });
        }
        catch(\Exception $e){
            return false;
            Log::error($e->getMessage(). $e->getTraceAsString());
        }
    }
}
