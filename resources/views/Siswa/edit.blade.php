@extends('layouts.dashboard')

@section('title', 'Edit Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="form-modern">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:48px;height:48px;background:var(--primary-light);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-pencil" style="color:var(--primary);font-size:1.3rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Edit Data Siswa</h5>
                    <small style="color:var(--gray);">Perbarui informasi siswa</small>
                </div>
            </div>

            <form action="{{ route('Siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                    <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror"
                           value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
                               value="{{ old('kelas', $siswa->kelas) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Siswa <span class="text-danger">*</span></label>
                    <textarea name="alamat_siswa" class="form-control" rows="3" required>{{ old('alamat_siswa', $siswa->alamat_siswa) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Total Poin</label>
                    <input type="number" name="total_poin" class="form-control @error('total_poin') is-invalid @enderror"
                           value="{{ old('total_poin', $siswa->total_poin) }}" min="0" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-modern">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('Siswa.index') }}" class="btn btn-light px-4" style="border-radius:10px;font-weight:500;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
