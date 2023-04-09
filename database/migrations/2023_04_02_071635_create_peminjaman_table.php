<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('id_peminjaman', 6)->primary();
            $table->integer('id_user');
            $table->string('id_peminjam', 6);
            $table->string('kd_aset', 6);
            $table->dateTime('tgl_pinjam');
            $table->integer('jml_peminjaman');
            $table->enum('status',['Proses', 'Aktif', 'Selesai', 'Ditolak']);
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
        Schema::dropIfExists('peminjaman');
    }
}
