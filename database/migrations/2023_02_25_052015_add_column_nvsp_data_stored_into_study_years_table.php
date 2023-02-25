<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNvspDataStoredIntoStudyYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_years', function (Blueprint $table) {
            //
            $table->tinyInteger('nvsp_data_stored')->default(0)->comment('Dữ liệu NVSP. 1: Đã tổng hợp, 0: Chưa tổng hợp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_years', function (Blueprint $table) {
            //
        });
    }
}
