<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNvspPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nvsp_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_study_year');
            $table->unsignedInteger('id_user');
            $table->string('level');
            $table->string('level_text');
            $table->string('note');
            $table->string('join_type')->nullable();
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
        Schema::dropIfExists('nvsp_points');
    }
}
