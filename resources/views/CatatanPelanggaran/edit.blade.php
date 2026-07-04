@extends('layouts.dashboard')

@section('title', 'Edit Catatan Pelanggaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-modern">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width:48px;height:48px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-pencil" style="color:var(--primary);font-size:1.3rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Edit Catatan Pelanggaran</h5>
                    <small style="color:var(--gray);">Perbarui catatan pelanggaran siswa</small>
                </div>
            </div>

            <form action="{{ route('CatatanPelanggaran.update', $catatan_pelanggaran->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <select name="nama_siswa" id="editCatNama" class="form-select" required onchange="editCatFillKelas()">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->nama_siswa }}" data-kelas="{{ $s->kelas }}"
                                    {{ $catatan_pelanggaran->nama_siswa == $s->nama_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }} ({{ $s->kelas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="kelas" id="editCatKelas" class="form-control" value="{{ $catatan_pelanggaran->kelas }}" readonly required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                        <select name="jenis_pelanggaran" class="form-select" required>
                            <option value="Ringan" {{ $catatan_pelanggaran->jenis_pelanggaran == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="Sedang" {{ $catatan_pelanggaran->jenis_pelanggaran == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Berat" {{ $catatan_pelanggaran->jenis_pelanggaran == 'Berat' ? 'selected' : '' }}>Berat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', $catatan_pelanggaran->tanggal) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                              rows="4" required>{{ old('keterangan', $catatan_pelanggaran->keterangan) }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Poin <span class="text-danger">*</span></label>
                        <input type="number" name="poin" class="form-control @error('poin') is-invalid @enderror"
                               value="{{ old('poin', $catatan_pelanggaran->poin) }}" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sanksi <span class="text-danger">*</span></label>
                        <input type="text" name="sanksi" class="form-control @error('sanksi') is-invalid @enderror"
                               value="{{ old('sanksi', $catatan_pelanggaran->sanksi) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Upload Bukti (PDF / Gambar)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    @if($catatan_pelanggaran->file)
                        <small style="color:var(--gray);" class="mt-2 d-block">
                            <i class="bi bi-paperclip"></i> File saat ini:
                            <a href="{{ asset('storage/'.$catatan_pelanggaran->file) }}" target="_blank" style="color:var(--primary);">{{ $catatan_pelanggaran->file }}</a>
                        </small>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-modern">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('CatatanPelanggaran.index') }}" class="btn btn-light px-4" style="border-radius:10px;font-weight:500;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCatFillKelas() {
    var sel = document.getElementById('editCatNama');
    var opt = sel.options[sel.selectedIndex];
    document.getElementById('editCatKelas').value = opt ? opt.dataset.kelas : '';
}
document.addEventListener('DOMContentLoaded', function() {
    editCatFillKelas();
});
</script>
@endsection
