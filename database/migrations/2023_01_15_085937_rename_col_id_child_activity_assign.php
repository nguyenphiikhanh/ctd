<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColIdChildActivityAssign extends Migration
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
            $table->renameColumn('id_child_activity_assign', 'id_activities_details_assign');
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
