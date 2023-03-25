<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_study_time');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_tieu_chi');
            $table->unsignedFloat('score');
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
        Schema::dropIfExists('personal_score');
    }
}
