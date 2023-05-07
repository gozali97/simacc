<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_aset', function (Blueprint $table) {
            $table->string('kd_det_aset')->primary();
            $table->string('kd_aset');
            $table->string('kd_ruang');
            $table->integer('kd_kondisi');
            $table->string('gambar');
            $table->date('tgl_masuk');
            $table->enum('status',['in', 'out']);
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
        Schema::dropIfExists('detail_aset');
    }
}
