<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColEndTimeClassMeetIntoStudyTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_times', function (Blueprint $table) {
            //
            $table->dateTime('end_time_class_meet')->nullable()->comment('kết thúc họp xét lớp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_times', function (Blueprint $table) {
            //
        });
    }
}
