<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColIdUserReceiveActivitiesToIdUserJoinActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_join_activity_prooves', function (Blueprint $table) {
            //
            $table->renameColumn('id_user_receive_activities', 'id_user_join_activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_join_activity_prooves', function (Blueprint $table) {
            //
        });
    }
}
