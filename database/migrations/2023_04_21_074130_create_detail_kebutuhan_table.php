<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKebutuhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_kebutuhan', function (Blueprint $table) {
            $table->string('kd_det_kebutuhan')->primary();
            $table->string('kd_kebutuhan');
            $table->string('verifikasi');
            $table->date('tgl_kebutuhan');
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
        Schema::dropIfExists('detail_kebutuhan');
    }
}
