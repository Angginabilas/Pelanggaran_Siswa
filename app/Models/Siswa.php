<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa',    // ✅ Sesuaikan dengan nama kolom di database
        'kelas',
        'jenis_kelamin',
        'alamat_siswa',
        'total_poin'
    ];

    // ✅ Mapping agar bisa pakai nama yang lebih mudah di controller
    protected $casts = [
        'total_poin' => 'integer'
    ];
}