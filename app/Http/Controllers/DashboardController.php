<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa       = Siswa::count();
        $totalPelanggaran = Pelanggaran::count();
        $totalPoin        = Siswa::sum('total_poin');

        $kategoriData = Pelanggaran::selectRaw('kategori, COUNT(*) as jumlah')
            ->groupBy('kategori')
            ->pluck('jumlah', 'kategori')
            ->toArray();

        return view('dashboard', compact(
            'totalSiswa',
            'totalPelanggaran',
            'totalPoin',
            'kategoriData'
        ));
    }
}
