<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserAssigneeIntoChildActivitiesTable extends Migration
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
            $table->unsignedInteger('id_user_assignee')->nullable()->comment('người phụ trách');
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
