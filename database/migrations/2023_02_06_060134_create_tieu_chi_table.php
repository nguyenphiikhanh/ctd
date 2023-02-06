<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTieuChiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tieu_chi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_loai_tieu_chi');
            $table->longText('name');
            $table->float('max_score');
            $table->tinyInteger('type');
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
        Schema::dropIfExists('tieu_chi');
    }
}
