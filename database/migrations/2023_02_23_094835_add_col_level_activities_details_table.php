<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColLevelActivitiesDetailsTable extends Migration
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
            $table->tinyInteger('level')->default(1)->comment('1: HĐ khoa, 2: HĐ trường, 3: Tọa đàm');
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
