@extends('layouts.dashboard')

@section('content')

<div class="container-fluid mt-4">
    <h5 class="mb-4">Form Siswa</h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('Siswa.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <label class="col-md-2">Nama Siswa</label>
            <div class="col-md-4">
                <input type="text" name="nama_siswa" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-md-2">Kelas</label>
            <div class="col-md-4">
                <input type="text" name="kelas" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-md-2">Jenis Kelamin</label>
            <div class="col-md-4">
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-md-2">Alamat Siswa</label>
            <div class="col-md-6">
                <textarea name="alamat_siswa" rows="4" class="form-control"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 text-end">
                <button class="btn btn-info text-white px-4">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection
