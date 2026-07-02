<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanPelanggaran;

class CatatanPelanggaranController extends Controller
{

    public function index(Request $request)
{
    $search = $request->search;


    $catatanPelanggarans = CatatanPelanggaran::when($search, function($query) use ($search){

        $query->where('nama_siswa','like','%'.$search.'%')
              ->orWhere('kelas','like','%'.$search.'%');

    })->get();



    return view('catatanpelanggaran.index', compact('catatanPelanggarans','search'));
}



    public function create()
    {
        return view('catatanpelanggaran.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_siswa'=>'required',
        'kelas'=>'required',
        'tanggal'=>'required',
        'kategori'=>'required',
        'pelanggaran'=>'required',
        'poin'=>'required',
        'sanksi'=>'required',
        'file'=>'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $filename = null;

    if ($request->hasFile('file')) {
        $filename = $request->file('file')->store('pelanggaran', 'public');
    }

    CatatanPelanggaran::create([
        'nama_siswa' => $request->nama_siswa,
        'kelas' => $request->kelas,
        'tanggal' => $request->tanggal,
        'jenis_pelanggaran' => $request->pelanggaran,
        'keterangan' => $request->pelanggaran,
        'poin' => $request->poin,
        'sanksi' => $request->sanksi,
        'file' => $filename,
    ]);

    return redirect()->route('CatatanPelanggaran.index')
        ->with('success', 'Data berhasil disimpan');
}

    public function edit($id)
    {
        $catatan_pelanggaran = CatatanPelanggaran::findOrFail($id);

        return view('catatanpelanggaran.edit',
        compact('catatan_pelanggaran'));
    }

    public function update(Request $request,$id)
{

    $request->validate([

        'nama_siswa'=>'required',
        'kelas'=>'required',
        'jenis_pelanggaran'=>'required',
        'tanggal'=>'required|date',
        'keterangan'=>'required',
        'poin'=>'required',
        'sanksi'=>'required',
        'file'=>'nullable|mimes:jpg,jpeg,png,pdf|max:2048',

    ]);


    $data = CatatanPelanggaran::findOrFail($id);


    $filename = $data->file;


    if($request->hasFile('file')){

        $filename = $request->file('file')
        ->store('pelanggaran','public');

    }



    $data->update([

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
    ->route('CatatanPelanggaran.index')
    ->with('success','Data berhasil diperbarui');

}

    public function destroy($id)
    {

        $data = CatatanPelanggaran::findOrFail($id);

        $data->delete();


        return redirect()
        ->route('CatatanPelanggaran.index')
        ->with('success','Data berhasil dihapus');

    }

}