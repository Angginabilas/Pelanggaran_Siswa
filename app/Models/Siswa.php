<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'jenis_kelamin',
        'alamat_siswa',
        'total_poin'
    ];

    protected $casts = [
        'total_poin' => 'integer'
    ];

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class, 'nama_siswa', 'nama_siswa');
    }

    public function catatanPelanggarans()
    {
        return $this->hasMany(CatatanPelanggaran::class, 'nama_siswa', 'nama_siswa');
    }
}
