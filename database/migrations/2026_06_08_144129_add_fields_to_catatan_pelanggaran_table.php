<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCatatanPelanggaranTable extends Migration
{
    public function up()
    {
        Schema::table('catatan_pelanggaran', function (Blueprint $table) {
            $table->string('nama_siswa')->after('id');
            $table->string('jenis_pelanggaran');
            $table->date('tanggal');
            $table->text('keterangan');
        });
    }

    public function down()
    {
        Schema::table('catatan_pelanggaran', function (Blueprint $table) {
            $table->dropColumn([
                'nama_siswa',
                'jenis_pelanggaran',
                'tanggal',
                'keterangan'
            ]);
        });
    }
}