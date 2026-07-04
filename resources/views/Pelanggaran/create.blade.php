@extends('layouts.dashboard')

@section('title', 'Tambah Pelanggaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-modern">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:48px;height:48px;background:#fef2f2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-exclamation-triangle" style="color:#ef4444;font-size:1.3rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Tambah Pelanggaran</h5>
                    <small style="color:var(--gray);">Catat pelanggaran siswa</small>
                </div>
            </div>

            <form action="{{ route('Pelanggaran.store') }}"
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
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Ringan" {{ old('kategori') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="Sedang" {{ old('kategori') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Berat" {{ old('kategori') == 'Berat' ? 'selected' : '' }}>Berat</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggaran <span class="text-danger">*</span></label>
                    <textarea name="pelanggaran" class="form-control @error('pelanggaran') is-invalid @enderror" rows="3" required placeholder="Deskripsikan pelanggaran yang dilakukan">{{ old('pelanggaran') }}</textarea>
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
                    <div class="drop-zone" id="drop-zone">
                        <p><i class="bi bi-cloud-upload" style="font-size:2rem;display:block;margin-bottom:8px;color:var(--primary);"></i></p>
                        <p>Tarik & lepas file disini<br>atau klik untuk memilih file</p>
                        <input type="file" name="file" id="fileInput" accept=".pdf,.jpg,.jpeg,.png" hidden>
                        <div class="file-name" id="fileName"></div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-modern">
                        <i class="bi bi-save"></i> Simpan Pelanggaran
                    </button>
                    <a href="{{ route('Pelanggaran.index') }}" class="btn btn-light px-4" style="border-radius:10px;font-weight:500;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        if (fileInput.files[0]) {
            fileName.textContent = '[File] ' + fileInput.files[0].name;
        }
    });

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('active');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('active');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('active');
        fileInput.files = e.dataTransfer.files;
        if (fileInput.files[0]) {
            fileName.textContent = '[File] ' + fileInput.files[0].name;
        }
    });
</script>
@endsection
