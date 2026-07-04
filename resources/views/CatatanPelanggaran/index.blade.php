@extends('layouts.dashboard')

@section('title', 'Catatan Pelanggaran')

@section('content')
<style>
    .row-click { cursor: pointer; transition: background 0.15s; }
    .row-click:hover { background: #eef2ff !important; }
    .action-btn-group { white-space: nowrap; }
    .slider-wrapper { display: flex; align-items: center; gap: 12px; }
    .slider-wrapper input[type=range] { flex: 1; height: 6px; -webkit-appearance: none; appearance: none; background: #e2e8f0; border-radius: 3px; outline: none; }
    .slider-wrapper input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 20px; height: 20px; border-radius: 50%; background: #d97706; cursor: pointer; border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
    .slider-value { min-width: 36px; height: 36px; background: #d97706; color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; }
    .file-preview-box { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-top: 8px; background: #f8fafc; }
    .file-preview-box img { width: 100%; max-height: 180px; object-fit: contain; display: block; border-radius:8px; }
    .file-preview-box iframe { width: 100%; height: 180px; border: none; border-radius:8px; }
    .file-preview-box .file-placeholder { padding: 24px; text-align: center; color: var(--gray); }
</style>
<div class="card-modern">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:#fffbeb;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;"><i class="bi bi-journal-richtext" style="color:#d97706;"></i></div>
                <div>
                    <h5 class="fw-bold mb-0" style="color:var(--dark);">Catatan Pelanggaran</h5>
                    <small style="color:var(--gray);">Catatan lengkap dengan <strong>kronologi kejadian & keterangan</strong> detail</small>
                </div>
            </div>
            @if(Auth::user()->role === 'admin')
            <button class="btn-primary-modern" data-bs-toggle="modal" data-bs-target="#modalCatCreate"><i class="bi bi-plus-lg"></i> Tambah</button>
            @endif
        </div>

        <form method="GET" action="{{ route('CatatanPelanggaran.index') }}" class="mb-4">
            <div class="input-group" style="max-width:380px;">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama atau kelas..." style="border-radius:10px 0 0 10px;border:1.5px solid #e2e8f0;">
                <button type="submit" style="background:var(--primary);color:#fff;border:none;padding:0 20px;border-radius:0 10px 10px 0;font-weight:600;"><i class="bi bi-search"></i></button>
                @if(request('search'))<a href="{{ route('CatatanPelanggaran.index') }}" class="btn btn-light" style="border-radius:10px;margin-left:8px;"><i class="bi bi-x-lg"></i></a>@endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Poin</th>
                        <th>Sanksi</th>
                        <th>File</th>
                        @if(Auth::user()->role === 'admin')<th style="text-align:center;">Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($catatanPelanggarans as $data)
                    <tr class="row-click" onclick="showDetailCat({{ $data->id }})" data-bs-toggle="modal" data-bs-target="#modalCatDetail">
                        <td>{{ $catatanPelanggarans->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $data->nama_siswa }}</strong></td>
                        <td>{{ $data->kelas }}</td>
                        <td>@php $b=match($data->jenis_pelanggaran){'Ringan'=>'bg-success','Sedang'=>'bg-warning text-dark','Berat'=>'bg-danger',default=>'bg-secondary'}; @endphp <span class="badge {{ $b }}">{{ $data->jenis_pelanggaran }}</span></td>
                        <td>{{ date('d/m/Y', strtotime($data->tanggal)) }}</td>
                        <td>{{ Str::limit($data->keterangan, 30) }}</td>
                        <td><span class="badge bg-info text-dark">{{ $data->poin }}</span></td>
                        <td>{{ Str::limit($data->sanksi, 20) }}</td>
                        <td>@if($data->file)<span class="badge bg-success">&#10003;</span>@else<span style="color:var(--gray);">-</span>@endif</td>
                        @if(Auth::user()->role === 'admin')
                        <td style="text-align:center;"><div class="action-btn-group" onclick="event.stopPropagation()">
                            <button class="btn-sm-modern btn-edit" onclick="openEditCat({{ $data->id }})" data-bs-toggle="modal" data-bs-target="#modalCatEdit"><i class="bi bi-pencil"></i></button>
                            <button class="btn-sm-modern btn-delete" onclick="confirmDelete('catatanpelanggaran',{{ $data->id }},'{{ $data->nama_siswa }}')" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete"><i class="bi bi-trash"></i></button>
                        </div></td>
                        @endif
                    </tr>
                    @empty
                    <tr><td colspan="{{ Auth::user()->role === 'admin' ? 10 : 9 }}" style="text-align:center;padding:40px;color:var(--gray);"><i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 pagination-modern">{{ $catatanPelanggarans->withQueryString()->links() }}</div>
    </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalCatDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-body p-0">
                <div style="background:linear-gradient(135deg,#d97706,#92400e);border-radius:16px 16px 0 0;padding:28px 24px;color:#fff;text-align:center;">
                    <div style="width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.6rem;"><i class="bi bi-journal-richtext"></i></div>
                    <h5 class="fw-bold mb-1" id="dCatNama">-</h5>
                    <span class="badge" style="background:rgba(255,255,255,0.2);" id="dCatKelas">-</span>
                    <span class="badge" style="background:rgba(255,255,255,0.2);margin-left:6px;" id="dCatJenis">-</span>
                </div>
                <div style="padding:24px;display:flex;gap:24px;">
                    <div style="flex:1;">
                        <table style="width:100%;">
                            <tr><td style="padding:10px 0;color:var(--gray);font-size:0.85rem;width:120px;">Tanggal</td><td style="padding:10px 0;font-weight:600;" id="dCatTgl">-</td></tr>
                            <tr><td style="padding:10px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Keterangan</td><td style="padding:10px 0;font-weight:600;border-top:1px solid #f1f5f9;" id="dCatKet">-</td></tr>
                            <tr><td style="padding:10px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Poin</td><td style="padding:10px 0;border-top:1px solid #f1f5f9;" id="dCatPoin"></td></tr>
                            <tr><td style="padding:10px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Sanksi</td><td style="padding:10px 0;font-weight:600;border-top:1px solid #f1f5f9;" id="dCatSanksi">-</td></tr>
                        </table>
                    </div>
                    <div style="width:220px;flex-shrink:0;">
                        <small style="color:var(--gray);font-weight:600;display:block;margin-bottom:6px;">BUKTI</small>
                        <div id="dCatFile" class="file-preview-box"><div class="file-placeholder">Tidak ada file</div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4"><button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Tutup</button></div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'admin')
<!-- MODAL CREATE -->
<div class="modal fade modal-custom" id="modalCatCreate" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#d97706,#92400e);"><h5 class="modal-title fw-bold"><i class="bi bi-plus-lg me-2"></i>Tambah Catatan Pelanggaran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="{{ route('CatatanPelanggaran.store') }}" method="POST" enctype="multipart/form-data">@csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <select name="nama_siswa" class="form-select" required onchange="fillKelas(this,'catCKelas')">
                                <option value="">— Pilih —</option>
                                @foreach($siswaList as $s)<option value="{{ $s->nama_siswa }}" data-kelas="{{ $s->kelas }}">{{ $s->nama_siswa }} ({{ $s->kelas }})</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Kelas <span class="text-danger">*</span></label><input type="text" id="catCKelas" name="kelas" class="form-control" readonly required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select name="jenis_pelanggaran" class="form-select" required>
                                <option value="">— Pilih —</option>
                                <option value="Ringan">Ringan</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Berat">Berat</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal <span class="text-danger">*</span></label><input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Keterangan <span class="text-danger">*</span></label><textarea name="keterangan" class="form-control" rows="3" required placeholder="Tulis kronologi kejadian secara detail..."></textarea></div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Poin <span class="text-danger">*</span></label>
                            <div class="slider-wrapper">
                                <input type="range" name="poin" min="1" max="10" step="1" value="5" oninput="catCPoin.value=this.value; catCPoinLabel.textContent=this.value">
                                <span class="slider-value" id="catCPoinLabel">5</span>
                                <input type="hidden" id="catCPoin" value="5">
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:var(--gray);padding:0 2px;"><span>Ringan</span><span>Sedang</span><span>Berat</span></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Sanksi <span class="text-danger">*</span></label><input type="text" name="sanksi" class="form-control" required placeholder="Sanksi yang diberikan"></div>
                    </div>
                    <div><label class="form-label">Upload Bukti <small style="color:var(--gray);">(opsional)</small></label><input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button><button type="submit" class="btn-primary-modern"><i class="bi bi-save"></i> Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade modal-custom" id="modalCatEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);"><h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Edit Catatan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="formCatEdit" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <select name="nama_siswa" id="eCatNama" class="form-select" required onchange="fillKelas(this,'eCatKelas')">
                                <option value="">— Pilih —</option>
                                @foreach($siswaList as $s)<option value="{{ $s->nama_siswa }}" data-kelas="{{ $s->kelas }}">{{ $s->nama_siswa }} ({{ $s->kelas }})</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Kelas <span class="text-danger">*</span></label><input type="text" id="eCatKelas" name="kelas" class="form-control" readonly required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                            <select name="jenis_pelanggaran" id="eCatJenis" class="form-select" required>
                                <option value="Ringan">Ringan</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Berat">Berat</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal <span class="text-danger">*</span></label><input type="date" name="tanggal" id="eCatTgl" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Keterangan <span class="text-danger">*</span></label><textarea name="keterangan" id="eCatKet" class="form-control" rows="3" required></textarea></div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Poin <span class="text-danger">*</span></label>
                            <div class="slider-wrapper">
                                <input type="range" name="poin" id="eCatPoinSlider" min="1" max="10" step="1" value="5" oninput="eCatPoinH.value=this.value; eCatPoinLabel.textContent=this.value">
                                <span class="slider-value" id="eCatPoinLabel">5</span>
                                <input type="hidden" id="eCatPoinH" name="poin" value="5">
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:var(--gray);padding:0 2px;"><span>Ringan</span><span>Sedang</span><span>Berat</span></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Sanksi <span class="text-danger">*</span></label><input type="text" name="sanksi" id="eCatSanksi" class="form-control" required></div>
                    </div>
                    <div><label class="form-label">Upload Bukti</label><input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png"><small id="eCatFileInfo" style="color:var(--gray);"></small></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button><button type="submit" class="btn-primary-modern"><i class="bi bi-check-lg"></i> Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function fillKelas(s,t){var o=s.options[s.selectedIndex];document.getElementById(t).value=o?o.dataset.kelas:''}
var catDS={!! $catatanPelanggarans->map(function($d){return['id'=>$d->id,'nama_siswa'=>$d->nama_siswa,'kelas'=>$d->kelas,'jenis_pelanggaran'=>$d->jenis_pelanggaran,'tanggal'=>$d->tanggal,'keterangan'=>$d->keterangan,'poin'=>$d->poin,'sanksi'=>$d->sanksi,'file'=>$d->file];})->toJson() !!};
function showDetailCat(id){
    var d=catDS.find(function(x){return x.id==id});if(!d)return;
    document.getElementById('dCatNama').textContent=d.nama_siswa;document.getElementById('dCatKelas').textContent=d.kelas;
    document.getElementById('dCatJenis').textContent=d.jenis_pelanggaran;document.getElementById('dCatTgl').textContent=d.tanggal;
    document.getElementById('dCatKet').textContent=d.keterangan;
    var stars='';for(var i=0;i<d.poin;i++)stars+='<i class="bi bi-star-fill" style="color:#f59e0b;font-size:1rem;"></i> ';
    document.getElementById('dCatPoin').innerHTML='<span style="font-weight:700;font-size:1rem;">'+d.poin+'/10</span> '+stars;
    document.getElementById('dCatSanksi').textContent=d.sanksi;
    var f=document.getElementById('dCatFile');
    if(d.file){
        var ext=d.file.split('.').pop().toLowerCase();
        if(ext=='jpg'||ext=='jpeg'||ext=='png')f.innerHTML='<img src="/storage/'+d.file+'" alt="Bukti" style="width:100%;max-height:250px;object-fit:contain;display:block;background:#f8fafc;">';
        else if(ext=='pdf')f.innerHTML='<iframe src="/storage/'+d.file+'" style="width:100%;height:250px;border:none;"></iframe>';
        else f.innerHTML='<div class="file-placeholder"><a href="/storage/'+d.file+'" target="_blank" style="color:var(--primary);font-weight:600;"><i class="bi bi-download"></i> Download File</a></div>';
    } else f.innerHTML='<div class="file-placeholder">Tidak ada file</div>';
}
function openEditCat(id){
    var d=catDS.find(function(x){return x.id==id});if(!d)return;
    document.getElementById('formCatEdit').action='/catatanpelanggaran/'+id;
    document.getElementById('eCatNama').value=d.nama_siswa;document.getElementById('eCatKelas').value=d.kelas;
    document.getElementById('eCatJenis').value=d.jenis_pelanggaran;document.getElementById('eCatTgl').value=d.tanggal;
    document.getElementById('eCatKet').value=d.keterangan;
    document.getElementById('eCatPoinSlider').value=d.poin;document.getElementById('eCatPoinH').value=d.poin;
    document.getElementById('eCatPoinLabel').textContent=d.poin;
    document.getElementById('eCatSanksi').value=d.sanksi;
    document.getElementById('eCatFileInfo').innerHTML=d.file?'<i class="bi bi-paperclip"></i> File: '+d.file:'';
}
</script>
@endif

<!-- MODAL CONFIRM DELETE + SCRIPT -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-body text-center py-4">
                <div style="width:60px;height:60px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;"><i class="bi bi-trash3" style="color:#ef4444;font-size:1.8rem;"></i></div>
                <h6 class="fw-bold mb-2">Konfirmasi Hapus</h6>
                <p class="mb-0" style="color:var(--gray);font-size:0.85rem;">Yakin ingin menghapus data <strong id="deleteItemName"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button>
                <form id="formDelete" method="POST" style="display:inline">@csrf @method('DELETE')
                    <button type="submit" class="btn" style="background:#ef4444;color:#fff;border-radius:10px;padding:10px 24px;font-weight:600;border:none;"><i class="bi bi-trash me-1"></i> Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function confirmDelete(t,i,n){document.getElementById('deleteItemName').textContent=n;document.getElementById('formDelete').action='/'+t+'/'+i;}
</script>
@endsection