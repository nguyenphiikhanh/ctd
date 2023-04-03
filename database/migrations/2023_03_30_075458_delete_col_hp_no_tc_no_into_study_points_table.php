<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColHpNoTcNoIntoStudyPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_points', function (Blueprint $table) {
            //
            $table->dropColumn('so_hp_no');
            $table->dropColumn('so_tin_chi_no');
            $table->unsignedInteger('tong_so_tin_dang_ky')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_points', function (Blueprint $table) {
            //
        });
    }
}
