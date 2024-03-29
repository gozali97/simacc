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
            $table->increments('kd_penghapusan');
            $table->integer('id_user');
            $table->integer('kd_aset');
            $table->date('tgl_penghapusan');
            $table->enum('status', ['Proses', 'Aktif', 'Selesai', 'Ditolak']);
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
