<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColSelfScoreCblScoreCvhtScoreIntoStudentClassMeetScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_class_meet_score', function (Blueprint $table) {
            //
            $table->dropColumn('score');
            $table->unsignedFloat('self_score')->default(0);
            $table->unsignedFloat('cbl_score')->default(0);
            $table->unsignedFloat('cvht_score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_class_meet_score', function (Blueprint $table) {
            //
        });
    }
}
