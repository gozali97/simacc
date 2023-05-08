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
            $table->string('kd_det_penghapusan')->primary();
            $table->string('kd_penghapusan');
            $table->string('tgl_penghapusan');
            $table->string('kd_det_aset');
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
