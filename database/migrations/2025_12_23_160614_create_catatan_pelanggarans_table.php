<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanPelanggaransTable extends Migration
{
    public function up()
    {
        Schema::create('catatan_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            $table->string('kelas');
            $table->string('jenis_pelanggaran');
            $table->date('tanggal');
            $table->text('keterangan');
            $table->integer('poin');
            $table->string('sanksi');
            $table->string('file')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catatan_pelanggaran');
    }
}
