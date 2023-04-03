<?php

use App\Http\Utils\RoleUtils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDataIntoClassMeetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    const tieuCHiIdsAdd = [2, 18, 19, 33];

    public function up()
    {
        //
        $userAddIds = DB::table('users')->where('role', RoleUtils::ROLE_SINHVIEN)
            ->orWhere('role', RoleUtils::ROLE_CBL)
            ->orWhere('role', RoleUtils::ROLE_LOP_TRUONG)
            ->pluck('id');
        $tieu_chi_add = DB::table('tieu_chi')->whereIn('id', self::tieuCHiIdsAdd)->pluck('id');
        foreach($userAddIds as $userId){
            $dataAdd = [];
            foreach($tieu_chi_add as $id_tieu_chi){
                $dataAdd[] = [
                    'id_study_time' => 2,
                    'id_user' => $userId,
                    'id_tieu_chi' => $id_tieu_chi
                ];
            }
            DB::table('student_class_meet_score')->insert($dataAdd);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
