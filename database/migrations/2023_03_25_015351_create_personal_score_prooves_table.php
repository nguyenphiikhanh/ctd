<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalScoreProovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_score_prooves', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_name_hash');
            $table->string('file_path');
            $table->unsignedBigInteger('id_personal_score');
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
        Schema::dropIfExists('personal_score_prooves');
    }
}
