<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassMeetFacultySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_meet_faculty_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_faculty');
            $table->unsignedInteger('id_study_time');
            $table->dateTime('end_time_class_meet')->nullable()->comment('thời gian kết thúc họp xét lớp');
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
        Schema::dropIfExists('class_meet_faculty_settings');
    }
}
