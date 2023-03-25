<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColStatusAndMaxScoreIntoPersonalScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal_score', function (Blueprint $table) {
            //
            $table->tinyInteger('status')->default(0)->comment('0: chưa có điểm; 1: đợi duyệt minh chứng; 2: không duyệt minh chứng; 3: hoàn thành');
            $table->unsignedFloat('max_score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_score', function (Blueprint $table) {
            //
        });
    }
}
