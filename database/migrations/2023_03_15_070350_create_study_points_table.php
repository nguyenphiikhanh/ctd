<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_study_time');
            $table->unsignedFloat('ten_level_avg')->nullable()->comment('trung bình thang 10');
            $table->string('ten_level_evaluate')->nullable()->comment('xếp loại thang 10');
            $table->unsignedFloat('four_level_avg')->nullable()->comment('trung bình thang 4');
            $table->string('four_level_evaluate')->nullable()->comment('xếp loại thang 4');
            $table->unsignedInteger('credit_in_debt')->default(0)->comment('số tín chỉ nợ');
            $table->unsignedInteger('object_in_debt')->default(0)->comment('số học phần nợ');
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
        Schema::dropIfExists('study_points');
    }
}
