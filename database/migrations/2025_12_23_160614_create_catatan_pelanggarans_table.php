<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCatatanPelanggaransTable extends Migration
{
    public function up()
    {
        Schema::table('catatan_pelanggaran', function (Blueprint $table) {
            $table->string('nama_siswa')->after('id');
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
        Schema::table('catatan_pelanggaran', function (Blueprint $table) {
            $table->dropColumn([
                'nama_siswa',
                'kelas',
                'jenis_pelanggaran',
                'tanggal',
                'keterangan',
                'poin',
                'sanksi',
                'file',
            ]);
        });
    }
}