<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_mutasi', function (Blueprint $table) {
            $table->increments('kd_det_mutasi');
            $table->integer('kd_mutasi');
            $table->string('kd_detail_aset');
            $table->integer('id_ruang');
            $table->date('tgl_mutasi');
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
        Schema::dropIfExists('detail_mutasi');
    }
}
