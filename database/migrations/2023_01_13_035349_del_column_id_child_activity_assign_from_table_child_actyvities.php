<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DelColumnIdChildActivityAssignFromTableChildActyvities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('child_activities', function (Blueprint $table) {
            //
            $table->dropColumn('id_child_activity_assign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('child_activities', function (Blueprint $table) {
            //
        });
    }
}
