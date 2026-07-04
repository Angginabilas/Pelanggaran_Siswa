<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        $siswas = Siswa::latest()->paginate(10);
        return view('Siswa.index', compact('siswas'));
    }

    // Menyimpan data siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|max:255',
            'kelas' => 'required|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_siswa' => 'required|max:500',
        ]);

        Siswa::create([
            'nama_siswa'   => $request->nama_siswa,
            'kelas'        => $request->kelas,
            'jenis_kelamin'=> $request->jenis_kelamin,
            'alamat_siswa' => $request->alamat_siswa,
            'total_poin'   => 0,
        ]);

        return redirect()->route('Siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    // Menampilkan form edit siswa
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('Siswa.edit', compact('siswa'));
    }

    // Memperbarui data siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|max:255',
            'kelas' => 'required|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_siswa' => 'required|max:500',
            'total_poin' => 'required|integer|min:0',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nama_siswa'   => $request->nama_siswa,
            'kelas'        => $request->kelas,
            'jenis_kelamin'=> $request->jenis_kelamin,
            'alamat_siswa' => $request->alamat_siswa,
            'total_poin'   => $request->total_poin,
        ]);

        return redirect()->route('Siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    // Menghapus siswa
    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();

        return redirect()->route('Siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
