@extends('layouts.dashboard')

@section('title', 'Data Siswa')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card-modern">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1" style="color:var(--dark);">
                            <i class="bi bi-people" style="color:var(--primary);"></i> Data Siswa
                        </h5>
                        <small style="color:var(--gray);">Total {{ $siswas->total() }} siswa terdaftar</small>
                    </div>
                    @if(Auth::user()->role === 'admin')
                    <button class="btn-primary-modern" data-bs-toggle="modal" data-bs-target="#modalSiswaCreate">
                        <i class="bi bi-plus-lg"></i> Tambah Siswa
                    </button>
                    @endif
                </div>

                <style>
                    .row-click { cursor: pointer; transition: background 0.15s; }
                    .row-click:hover { background: #eef2ff !important; }
                    .action-btn-group { white-space: nowrap; }
                    .action-btn-group .btn-sm-modern { margin: 0 2px; }
                </style>
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>JK</th>
                                <th>Poin</th>
                                @if(Auth::user()->role === 'admin')
                                <th style="text-align:center;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $s)
                                <tr id="siswa-row-{{ $s->id }}" class="row-click"
                                    onclick="showDetailSiswa({{ $s->id }})"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalSiswaDetail">
                                    <td>{{ $siswas->firstItem() + $loop->index }}</td>
                                    <td><strong>{{ $s->nama_siswa }}</strong></td>
                                    <td>{{ $s->kelas }}</td>
                                    <td>{{ $s->jenis_kelamin }}</td>
                                    <td><span class="badge bg-warning text-dark">{{ $s->total_poin }}</span></td>
                                    @if(Auth::user()->role === 'admin')
                                    <td style="text-align:center;">
                                        <div class="action-btn-group" onclick="event.stopPropagation()">
                                            <button class="btn-sm-modern btn-edit"
                                                    onclick="openEditSiswa({{ $s->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalSiswaEdit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn-sm-modern btn-delete"
                                                    onclick="confirmDelete('siswa', {{ $s->id }}, '{{ $s->nama_siswa }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalConfirmDelete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'admin' ? 6 : 5 }}" style="text-align:center;padding:40px;color:var(--gray);">
                                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                                        Belum ada data siswa
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 pagination-modern">
                    {{ $siswas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'admin')
<!-- ─── MODAL CREATE SISWA ─── -->
<div class="modal fade modal-custom" id="modalSiswaCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Siswa.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_siswa" class="form-control" required placeholder="Nama lengkap">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control" required placeholder="Contoh: X IPA 1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">— Pilih —</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat_siswa" class="form-control" rows="3" required placeholder="Alamat lengkap"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button>
                    <button type="submit" class="btn-primary-modern"><i class="bi bi-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ─── MODAL EDIT SISWA ─── -->
<div class="modal fade modal-custom" id="modalSiswaEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Edit Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditSiswa" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_siswa" id="editSiswaNama" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" id="editSiswaKelas" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" id="editSiswaJk" class="form-select" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat_siswa" id="editSiswaAlamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Total Poin</label>
                        <input type="number" name="total_poin" id="editSiswaPoin" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button>
                    <button type="submit" class="btn-primary-modern"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Open Edit Siswa - fill modal with data
function openEditSiswa(id) {
    var row = document.getElementById('siswa-row-' + id);
    if (!row) return;

    // We need data - since we have it from the table, we'll fetch via AJAX
    // But simpler: store data-attributes on the button itself
    // Actually, let's fetch from a simple endpoint
    fetch('/siswa/' + id + '/edit')
        .then(r => r.text())
        .then(html => {
            // Parse the response to get values - OR we can use a JSON endpoint
            // Simpler: use data attributes we'll embed
        });

    // Even simpler: use inline data from the rendered table
    // We'll set a global data store
    var siswaData = {!! $siswas->map(function($s) {
        return [
            'id' => $s->id,
            'nama_siswa' => $s->nama_siswa,
            'kelas' => $s->kelas,
            'jenis_kelamin' => $s->jenis_kelamin,
            'alamat_siswa' => $s->alamat_siswa,
            'total_poin' => $s->total_poin,
        ];
    })->toJson() !!};

    var data = siswaData.find(function(s) { return s.id == id; });
    if (!data) return;

    document.getElementById('formEditSiswa').action = '/siswa/' + id;
    document.getElementById('editSiswaNama').value = data.nama_siswa;
    document.getElementById('editSiswaKelas').value = data.kelas;
    document.getElementById('editSiswaJk').value = data.jenis_kelamin;
    document.getElementById('editSiswaAlamat').value = data.alamat_siswa;
    document.getElementById('editSiswaPoin').value = data.total_poin;
}
</script>
@endif

<!-- ─── MODAL DETAIL SISWA ─── -->
<div class="modal fade" id="modalSiswaDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-body p-0">
                <!-- Profile header -->
                <div style="background:linear-gradient(135deg,#4f46e5,#6366f1);border-radius:16px 16px 0 0;padding:32px 24px;text-align:center;color:#fff;">
                    <div style="width:64px;height:64px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:2rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-1" id="detailSiswaNama">-</h5>
                    <span class="badge" style="background:rgba(255,255,255,0.2);font-size:0.8rem;" id="detailSiswaKelas">-</span>
                </div>
                <!-- Info body -->
                <div style="padding:24px;">
                    <table style="width:100%;">
                        <tr>
                            <td style="padding:10px 0;color:var(--gray);font-size:0.85rem;width:120px;">Jenis Kelamin</td>
                            <td style="padding:10px 0;font-weight:600;font-size:0.9rem;" id="detailSiswaJk">-</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Alamat</td>
                            <td style="padding:10px 0;font-weight:600;font-size:0.9rem;border-top:1px solid #f1f5f9;" id="detailSiswaAlamat">-</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Total Poin</td>
                            <td style="padding:10px 0;border-top:1px solid #f1f5f9;" id="detailSiswaPoin"><span class="badge bg-warning text-dark">-</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
// Detail Siswa
function showDetailSiswa(id) {
    var data = siswaDataStore.find(function(s) { return s.id == id; });
    if (!data) return;
    document.getElementById('detailSiswaNama').textContent = data.nama_siswa;
    document.getElementById('detailSiswaKelas').textContent = data.kelas;
    document.getElementById('detailSiswaJk').textContent = data.jenis_kelamin;
    document.getElementById('detailSiswaAlamat').textContent = data.alamat_siswa;
    document.getElementById('detailSiswaPoin').innerHTML = '<span class=\"badge bg-warning text-dark\">' + data.total_poin + ' poin</span>';
}
</script>

<!-- ─── MODAL CONFIRM DELETE ─── -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-body text-center py-4">
                <div style="width:60px;height:60px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="bi bi-trash3" style="color:#ef4444;font-size:1.8rem;"></i>
                </div>
                <h6 class="fw-bold mb-2">Konfirmasi Hapus</h6>
                <p class="mb-0" style="color:var(--gray);font-size:0.85rem;">
                    Yakin ingin menghapus <strong id="deleteItemName"></strong>?
                </p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button>
                <form id="formDelete" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background:#ef4444;color:#fff;border-radius:10px;padding:10px 24px;font-weight:600;border:none;">
                        <i class="bi bi-trash me-1"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Confirm delete handler
function confirmDelete(type, id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('formDelete').action = '/' + type + '/' + id;
}

// Siswa edit data store (reusable across all JS functions)
var siswaDataStore = {!! $siswas->map(function($s) {
    return [
        'id' => $s->id,
        'nama_siswa' => $s->nama_siswa,
        'kelas' => $s->kelas,
        'jenis_kelamin' => $s->jenis_kelamin,
        'alamat_siswa' => $s->alamat_siswa,
        'total_poin' => $s->total_poin,
    ];
})->toJson() !!};

// Override openEditSiswa to use dataStore
function openEditSiswa(id) {
    var data = siswaDataStore.find(function(s) { return s.id == id; });
    if (!data) return;

    document.getElementById('formEditSiswa').action = '/siswa/' + id;
    document.getElementById('editSiswaNama').value = data.nama_siswa;
    document.getElementById('editSiswaKelas').value = data.kelas;
    document.getElementById('editSiswaJk').value = data.jenis_kelamin;
    document.getElementById('editSiswaAlamat').value = data.alamat_siswa;
    document.getElementById('editSiswaPoin').value = data.total_poin;
}
</script>
@endsection
