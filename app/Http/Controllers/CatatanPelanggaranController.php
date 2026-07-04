<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanPelanggaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class CatatanPelanggaranController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;

        $catatanPelanggarans = CatatanPelanggaran::when($search, function ($query) use ($search) {
            $query->where('nama_siswa', 'like', '%' . $search . '%')
                ->orWhere('kelas', 'like', '%' . $search . '%');
        })->latest('tanggal')->paginate(10);

        $siswaList = Siswa::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']);

        return view('catatanpelanggaran.index', compact('catatanPelanggarans', 'search', 'siswaList'));
    }

    public function create()
    {
        $siswaList = Siswa::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']);
        return view('catatanpelanggaran.create', compact('siswaList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|max:255',
            'kelas' => 'required|max:50',
            'jenis_pelanggaran' => 'required|in:Ringan,Sedang,Berat',
            'tanggal' => 'required|date',
            'keterangan' => 'required|max:1000',
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

        CatatanPelanggaran::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'poin' => $request->poin,
            'sanksi' => $request->sanksi,
            'file' => $filename,
        ]);

        return redirect()->route('CatatanPelanggaran.index')
            ->with('success', 'Data catatan pelanggaran berhasil disimpan');
    }

    public function edit($id)
    {
        $catatan_pelanggaran = CatatanPelanggaran::findOrFail($id);
        $siswaList = Siswa::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']);
        return view('catatanpelanggaran.edit', compact('catatan_pelanggaran', 'siswaList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|max:255',
            'kelas' => 'required|max:50',
            'jenis_pelanggaran' => 'required|in:Ringan,Sedang,Berat',
            'tanggal' => 'required|date',
            'keterangan' => 'required|max:1000',
            'poin' => 'required|integer|min:1|max:10',
            'sanksi' => 'required|max:500',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute minimal :min',
            'max' => ':attribute maksimal :max karakter',
        ]);

        $data = CatatanPelanggaran::findOrFail($id);
        $filename = $data->file;

        if ($request->hasFile('file')) {
            if ($data->file && Storage::disk('public')->exists($data->file)) {
                Storage::disk('public')->delete($data->file);
            }
            $filename = $request->file('file')->store('pelanggaran', 'public');
        }

        $data->update([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'poin' => $request->poin,
            'sanksi' => $request->sanksi,
            'file' => $filename,
        ]);

        return redirect()->route('CatatanPelanggaran.index')
            ->with('success', 'Data catatan pelanggaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = CatatanPelanggaran::findOrFail($id);

        if ($data->file && Storage::disk('public')->exists($data->file)) {
            Storage::disk('public')->delete($data->file);
        }

        $data->delete();

        return redirect()->route('CatatanPelanggaran.index')
            ->with('success', 'Data catatan pelanggaran berhasil dihapus');
    }

}
