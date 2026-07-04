@extends('layouts.dashboard')

@section('title', 'Tambah Catatan Pelanggaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-modern">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:48px;height:48px;background:#fef2f2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-journal-plus" style="color:#ef4444;font-size:1.3rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Tambah Catatan Pelanggaran</h5>
                    <small style="color:var(--gray);">Buat catatan pelanggaran baru</small>
                </div>
            </div>

            <form action="{{ route('CatatanPelanggaran.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" required placeholder="Nama lengkap siswa">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}" required placeholder="Contoh: X IPA 1">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                        <select name="jenis_pelanggaran" class="form-select @error('jenis_pelanggaran') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="Ringan" {{ old('jenis_pelanggaran') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="Sedang" {{ old('jenis_pelanggaran') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Berat" {{ old('jenis_pelanggaran') == 'Berat' ? 'selected' : '' }}>Berat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" required placeholder="Deskripsikan kejadian pelanggaran">{{ old('keterangan') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Poin <span class="text-danger">*</span></label>
                        <input type="number" name="poin" class="form-control @error('poin') is-invalid @enderror" value="{{ old('poin') }}" min="0" required placeholder="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sanksi <span class="text-danger">*</span></label>
                        <input type="text" name="sanksi" class="form-control @error('sanksi') is-invalid @enderror" value="{{ old('sanksi') }}" required placeholder="Sanksi yang diberikan">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Upload Bukti (PDF / Gambar)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-modern">
                        <i class="bi bi-save"></i> Simpan Catatan
                    </button>
                    <a href="{{ route('CatatanPelanggaran.index') }}" class="btn btn-light px-4" style="border-radius:10px;font-weight:500;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
