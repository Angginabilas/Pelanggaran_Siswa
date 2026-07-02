<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\CatatanPelanggaran;

class PelanggaranController extends Controller
{

    // Menampilkan semua data pelanggaran
    public function index()
    {
        $pelanggarans = Pelanggaran::all();

        return view('pelanggaran.index', compact('pelanggarans'));
    }


    // Menampilkan form tambah data
    public function create()
    {
        return view('pelanggaran.create');
    }


    // Menyimpan data pelanggaran
    public function store(Request $request)
{

    $request->validate([

        'nama_siswa'=>'required',
        'kelas'=>'required',
        'jenis_pelanggaran'=>'required',
        'tanggal'=>'required',
        'keterangan'=>'required',
        'poin'=>'required',
        'sanksi'=>'required',

    ]);



    $filename = null;


    if($request->hasFile('file')){

        $filename = $request->file('file')
        ->store('pelanggaran','public');

    }



    CatatanPelanggaran::create([

        'nama_siswa'=>$request->nama_siswa,

        'kelas'=>$request->kelas,

        'jenis_pelanggaran'=>$request->jenis_pelanggaran,

        'tanggal'=>$request->tanggal,

        'keterangan'=>$request->keterangan,

        'poin'=>$request->poin,

        'sanksi'=>$request->sanksi,

        'file'=>$filename,

    ]);



    return redirect()
    ->route('pelanggaran.index')
    ->with('success','Data berhasil disimpan');

}

    // Menampilkan form edit
    public function edit($id)
    {

        $pelanggaran = Pelanggaran::findOrFail($id);


        return view('pelanggaran.edit', compact('pelanggaran'));

    }




    // Update data
    public function update(Request $request, $id)
    {

        $request->validate([

            'nama_siswa' => 'required',
            'kelas' => 'required',
            'tanggal' => 'required',
            'kategori' => 'required',
            'pelanggaran' => 'required',
            'poin' => 'required',
            'sanksi' => 'required',
            'file'=>'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        $pelanggaran = Pelanggaran::findOrFail($id);


        $pelanggaran->update([

            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'pelanggaran' => $request->pelanggaran,
            'poin' => $request->poin,
            'sanksi' => $request->sanksi,
            'file' => $filename,
        ]);


        return redirect()
            ->route('Pelanggaran.index')
            ->with('success', 'Data berhasil diupdate');

    }




    // Hapus data
    public function destroy($id)
    {

        $pelanggaran = Pelanggaran::findOrFail($id);


        $pelanggaran->delete();


        return redirect()
            ->route('Pelanggaran.index')
            ->with('success', 'Data berhasil dihapus');

    }

}