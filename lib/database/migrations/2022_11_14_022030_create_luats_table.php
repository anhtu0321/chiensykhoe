<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLuatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_quy_tac');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->integer('gioi_tinh');
            $table->integer('mon_thi');
            $table->integer('dat');
            $table->integer('kha');
            $table->integer('gioi');
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
        Schema::dropIfExists('luat');
    }
}
