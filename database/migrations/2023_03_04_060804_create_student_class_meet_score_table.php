<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassMeetScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_class_meet_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_study_time');
            $table->unsignedInteger('id_tieu_chi');
            $table->unsignedInteger('id_user');
            $table->unsignedFloat('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_class_meet_score');
    }
}
