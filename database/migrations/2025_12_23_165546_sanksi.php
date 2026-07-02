<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sanksi'); // Nama sanksi/hukuman
            $table->string('deskripsi')->nullable(); // Penjelasan sanksi
            $table->integer('poin')->default(0); // Poin pelanggaran
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanksi');
    }
};
