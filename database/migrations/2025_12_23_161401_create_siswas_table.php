<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Buat tabel siswa lengkap
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');            // Nama siswa
            $table->string('kelas');           // Kelas siswa
            $table->string('jenis_kelamin');   // Laki-laki / Perempuan
            $table->text('alamat_siswa');            // Alamat siswa
            $table->integer('total_poin')->default(0); // Total poin default 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
