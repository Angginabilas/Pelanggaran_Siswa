<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class PelanggaranController extends Controller
{

    public function index()
    {
        $pelanggarans = Pelanggaran::latest()->paginate(10);
        $siswaList = Siswa::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']);
        return view('pelanggaran.index', compact('pelanggarans', 'siswaList'));
    }

    public function create()
    {
        $siswaList = Siswa::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']);
        return view('pelanggaran.create', compact('siswaList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|max:255',
            'kelas' => 'required|max:50',
            'kategori' => 'required|in:Ringan,Sedang,Berat',
            'tanggal' => 'required|date',
            'pelanggaran' => 'required|max:1000',
            'keterangan' => 'nullable|max:2000',
            'poin' => 'required|integer|min:1|max:10',
            'sanksi' => 'required|max:500',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute minimal :min',
            'max' => ':attribute maksimal :max karakter',
        ]);

        $filename = null;
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('pelanggaran', 'public');
        }

        Pelanggaran::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'pelanggaran' => $request->pelanggaran,
            'keterangan' => $request->keterangan,
            'poin' => $request->poin,
            'sanksi' => $request->sanksi,
            'file' => $filename,
        ]);

        return redirect()->route('Pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil disimpan');
    }

    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $siswaList = Siswa::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']);
        return view('pelanggaran.edit', compact('pelanggaran', 'siswaList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|max:255',
            'kelas' => 'required|max:50',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Ringan,Sedang,Berat',
            'pelanggaran' => 'required|max:1000',
            'poin' => 'required|integer|min:1|max:10',
            'sanksi' => 'required|max:500',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute minimal :min',
            'max' => ':attribute maksimal :max karakter',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $filename = $pelanggaran->file;

        if ($request->hasFile('file')) {
            if ($pelanggaran->file && Storage::disk('public')->exists($pelanggaran->file)) {
                Storage::disk('public')->delete($pelanggaran->file);
            }
            $filename = $request->file('file')->store('pelanggaran', 'public');
        }

        $pelanggaran->update([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'pelanggaran' => $request->pelanggaran,
            'keterangan' => $request->keterangan,
            'poin' => $request->poin,
            'sanksi' => $request->sanksi,
            'file' => $filename,
        ]);

        return redirect()->route('Pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        if ($pelanggaran->file && Storage::disk('public')->exists($pelanggaran->file)) {
            Storage::disk('public')->delete($pelanggaran->file);
        }

        $pelanggaran->delete();

        return redirect()->route('Pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus');
    }

}
