<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenghapusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghapusan', function (Blueprint $table) {
            $table->string('kd_penghapusan')->primary();
            $table->integer('id_user');
            $table->string('kd_det_aset');
            $table->string('kondisi_akhir');
            $table->date('tgl_penghapusan');
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
        Schema::dropIfExists('penghapusan');
    }
}
