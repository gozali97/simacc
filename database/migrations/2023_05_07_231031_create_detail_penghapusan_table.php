<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenghapusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penghapusan', function (Blueprint $table) {
            $table->integer('kd_det_penghapusan');
            $table->integer('kd_penghapusan');
            $table->date('tgl_penghapusan');
            $table->integer('kd_det_aset');
            $table->string('kondisi_akhir');
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
        Schema::dropIfExists('detail_penghapusan');
    }
}
