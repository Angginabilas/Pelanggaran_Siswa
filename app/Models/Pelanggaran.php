<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggarans'; // nama tabel di database
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'tanggal',
        'kategori',
        'pelanggaran',
        'poin',
        'sanksi',
        'file',
    ];
}
