<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\CatatanPelanggaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggaran = Pelanggaran::count();
        $totalCatatan     = CatatanPelanggaran::count();
        $totalPoin        = Siswa::sum('total_poin');

        // Ambil data kategori pelanggaran
        $kategoriData = Pelanggaran::selectRaw('kategori, COUNT(*) as jumlah')
        ->groupBy('kategori')
        ->pluck('jumlah', 'kategori');

        // Pastikan selalu array asosiatif
        $kategoriData = is_array($kategoriData) ? $kategoriData : $kategoriData->toArray();
        $kategoriData = (array) $kategoriData; // FORCE menjadi array asosiatif

        return view('dashboard', compact(
            'totalPelanggaran',
            'totalCatatan',
            'totalPoin',
            'kategoriData'
        ));
    }
}
