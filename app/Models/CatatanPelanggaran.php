<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanPelanggaran extends Model
{
    protected $table = 'catatan_pelanggaran';

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'jenis_pelanggaran',
        'tanggal',
        'keterangan',
        'poin',
        'sanksi',
        'file',
    ];

    public $timestamps = false;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nama_siswa', 'nama_siswa');
    }
}
