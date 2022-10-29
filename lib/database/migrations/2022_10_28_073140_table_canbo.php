<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCanbo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canbo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ho_ten');
            $table->integer('nam_sinh');
            $table->string('gioi_tinh');
            $table->integer('cap_bac');
            $table->integer('chuc_vu');
            $table->integer('don_vi');
            $table->softDeletes();;
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
