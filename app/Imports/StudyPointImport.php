<?php

namespace App\Imports;

use App\Models\StudyTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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
                    $import['ten_level_evaluate'] = $row['xep_loai_thang_10'];
                    $import['four_level_evaluate'] = $row['xep_loai_thang_4'];
                    $import['credit_in_debt'] = $row['so_tin_chi_no'];
                    $import['object_in_debt'] = $row['so_hp_no'];
                    DB::table('study_points')->updateOrInsert(
                        ['id_user' => $import['id_user'], 'id_study_time' => $import['id_study_time']],
                        $import
                    );
                }
            });
            return true;
        }
        catch(\Exception $e){
            return false;
            Log::error($e->getMessage(). $e->getTraceAsString());
        }
    }
}
