<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColStateFlgIntoChildActivitiesTable extends Migration
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
            $table->tinyInteger('state_flg')->comment('cờ thao tác')->default(1);
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
