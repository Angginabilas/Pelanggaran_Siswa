<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggarans';
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'tanggal',
        'kategori',
        'pelanggaran',
        'keterangan',
        'poin',
        'sanksi',
        'file',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nama_siswa', 'nama_siswa');
    }
}
