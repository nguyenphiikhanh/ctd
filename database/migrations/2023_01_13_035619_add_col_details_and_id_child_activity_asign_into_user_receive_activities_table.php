<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColDetailsAndIdChildActivityAsignIntoUserReceiveActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_receive_activities', function (Blueprint $table) {
            //
            $table->integer('id_child_activity_assign')->nullable();
            $table->longText('small_role_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_receive_activities', function (Blueprint $table) {
            //
        });
    }
}
