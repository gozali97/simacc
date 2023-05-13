<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKebutuhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kebutuhan', function (Blueprint $table) {
            $table->increments('kd_kebutuhan');
            $table->string('nama_kebutuhan');
            $table->integer('jumlah');
            $table->string('gambar');
            $table->date('tgl_kebutuhan');
            $table->enum('status', ['Proses', 'Selesai']);
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
        Schema::dropIfExists('kebutuhans');
    }
}
