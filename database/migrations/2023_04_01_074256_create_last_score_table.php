<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_study_time');
            $table->unsignedBigInteger('id_user');
            $table->double('sum_score')->default(0);
            $table->string('rank')->default('chưa xếp loại');
            $table->double('last_score')->default(0);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('last_score');
    }
}
