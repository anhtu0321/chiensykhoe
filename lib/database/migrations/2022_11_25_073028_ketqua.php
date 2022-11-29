<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ketqua extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ketqua', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_ds_canbo');
            $table->integer('id_ds_monthi');
            $table->integer('diem');
            $table->string('xeploai');
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
        //
    }
}
