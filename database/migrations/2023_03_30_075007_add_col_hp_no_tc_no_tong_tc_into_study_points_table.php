<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColHpNoTcNoTongTcIntoStudyPointsTable extends Migration
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
            $table->unsignedInteger('so_hp_no')->nullable();
            $table->unsignedInteger('so_tin_chi_no')->nullable();
            $table->unsignedInteger('tong_so_tin_dang_ky')->nullable();
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
