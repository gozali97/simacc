<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->string('kd_kembali')->primary();
            $table->string('kd_peminjaman');
            $table->integer('id_user');
            $table->date('tgl_kembali');
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
        Schema::dropIfExists('pengembalian');
    }
}
