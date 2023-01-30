<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJoinActivityProovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_join_activity_prooves', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_name_hash');
            $table->string('file_path');
            $table->bigInteger('id_user_receive_activities');
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
        Schema::dropIfExists('user_join_activity_prooves');
    }
}
