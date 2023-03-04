<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnEndTimeClassMeetFromTableStudyTimeTable extends Migration
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
            $table->dropColumn('end_time_class_meet');
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
