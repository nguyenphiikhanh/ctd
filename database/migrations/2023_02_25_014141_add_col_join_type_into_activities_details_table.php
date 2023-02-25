<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColJoinTypeIntoActivitiesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities_details', function (Blueprint $table) {
            //
            $table->tinyInteger('join_type')->nullable()->default(0)->comment('0: Thi nhóm, 1: Thi cá nhân');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities_details', function (Blueprint $table) {
            //
        });
    }
}
