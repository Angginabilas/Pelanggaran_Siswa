@extends('layouts.dashboard')

@section('title', 'Edit Catatan Pelanggaran')

@section('content')

<div class="container-fluid mt-2">

    <div class="card mt-3">

        <div class="card-body">

            <form action="{{ route('CatatanPelanggaran.update', $catatan_pelanggaran->id) }}" 
                  method="POST">

                @csrf
                @method('PUT')


                <div class="mb-3">
                    <label>Nama Siswa</label>

                    <input type="text"
                           name="nama_siswa"
                           class="form-control"
                           value="{{ $catatan_pelanggaran->nama_siswa }}"
                           required>
                </div>

                <div class="mb-3">
                    <label>Kelas</label>

                    <input type="text"
                           name="kelas"
                           class="form-control"
                           value="{{ $catatan_pelanggaran->kelas }}"
                           required>
                </div>

                <div class="mb-3">

                    <label>Jenis Pelanggaran</label>

                    <select name="jenis_pelanggaran" 
                            class="form-control"
                            required>

                        <option value="Ringan"
                        {{ $catatan_pelanggaran->jenis_pelanggaran == 'Ringan' ? 'selected' : '' }}>
                            Ringan
                        </option>


                        <option value="Sedang"
                        {{ $catatan_pelanggaran->jenis_pelanggaran == 'Sedang' ? 'selected' : '' }}>
                            Sedang
                        </option>


                        <option value="Berat"
                        {{ $catatan_pelanggaran->jenis_pelanggaran == 'Berat' ? 'selected' : '' }}>
                            Berat
                        </option>

                    </select>

                </div>


                <div class="mb-3">

                    <label>Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ $catatan_pelanggaran->tanggal }}"
                           required>

                </div>


                <div class="mb-3">

                    <label>Keterangan</label>

                    <textarea name="keterangan"
                              class="form-control"
                              rows="4"
                              required>{{ $catatan_pelanggaran->keterangan }}</textarea>

                </div>

                <div class="mb-3">
            <label>Poin</label>

            <input type="number"
                name="poin"
                class="form-control"
                value="{{ old('poin', $catatan_pelanggaran->poin ?? '') }}"
                required>
                </div>

                <div class="mb-3">

                    <label>Sanksi</label>

                    <textarea name="sanksi"
                              class="form-control"
                              rows="4"
                              required>{{ $catatan_pelanggaran->sanksi }}</textarea>

                </div>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>


                <a href="{{ route('CatatanPelanggaran.index') }}" 
                   class="btn btn-secondary">
                    Kembali
                </a>


            </form>

        </div>

    </div>

</div>

@endsection