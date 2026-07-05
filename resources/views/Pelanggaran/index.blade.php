@extends('layouts.dashboard')

@section('title', 'Data Pelanggaran')

@section('content')
<style>
    .row-click { cursor: pointer; transition: background 0.15s; }
    .row-click:hover { background: #eef2ff !important; }
    .action-btn-group { white-space: nowrap; }
    .slider-wrapper { display: flex; align-items: center; gap: 12px; }
    .slider-wrapper input[type=range] { flex: 1; height: 6px; -webkit-appearance: none; appearance: none; border-radius: 3px; outline: none; background: #e2e8f0; }
    .slider-wrapper input[type=range]::-webkit-slider-runnable-track { height: 6px; border-radius: 3px; background: inherit; }
    .slider-wrapper input[type=range]::-moz-range-track { height: 6px; border-radius: 3px; border: none; background: inherit; }
    .slider-wrapper input[type=range]::-moz-range-thumb { width: 22px; height: 22px; border-radius: 50%; cursor: pointer; border: 3px solid #fff; background: #4f46e5; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    .slider-wrapper input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 22px; height: 22px; border-radius: 50%; cursor: pointer; border: 3px solid #fff; background: #4f46e5; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    .slider-value { min-width: 40px; height: 40px; border-radius: 12px; background: #4f46e5; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; transition: background 0.2s; }
    .file-preview-box { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #f8fafc; }
    .file-preview-box img { width: 100%; max-height: 200px; object-fit: contain; display: block; border-radius:8px; }
    .file-preview-box iframe { width: 100%; height: 200px; border: none; border-radius:8px; }
    .file-preview-box .file-placeholder { padding: 20px; text-align: center; color: var(--gray); font-size:0.85rem; }
    .slider-indicator { font-size:0.75rem; font-weight:500; margin-top:4px; transition: color 0.2s; }
</style>

<div class="card-modern">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-0" style="color:var(--dark);">Data Pelanggaran</h5>
                <small style="color:var(--gray);">Catat dan kelola pelanggaran siswa</small>
            </div>
            @if(Auth::user()->role === 'admin')
            <button class="btn-primary-modern" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg"></i> Tambah</button>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Pelanggaran</th>
                        <th>Tanggal</th>
                        <th>Poin</th>
                        <th>Sanksi</th>
                        <th>File</th>
                        @if(Auth::user()->role === 'admin')<th style="text-align:center;">Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggarans as $d)
                    <tr class="row-click" onclick="showDetail({{ $d->id }})" data-bs-toggle="modal" data-bs-target="#modalDetail">
                        <td>{{ $pelanggarans->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $d->nama_siswa }}</strong></td>
                        <td>{{ $d->kelas }}</td>
                        <td>@php $b=match($d->kategori){'Ringan'=>'bg-success','Sedang'=>'bg-warning text-dark','Berat'=>'bg-danger',default=>'bg-secondary'}; @endphp <span class="badge {{ $b }}">{{ $d->kategori }}</span></td>
                        <td>{{ Str::limit($d->pelanggaran, 30) }}</td>
                        <td>{{ date('d/m/Y', strtotime($d->tanggal)) }}</td>
                        <td><span class="badge bg-info text-dark">{{ $d->poin }}</span></td>
                        <td>{{ Str::limit($d->sanksi, 20) }}</td>
                        <td>@if($d->file)<span class="badge bg-success">ada</span>@else<span style="color:var(--gray);">-</span>@endif</td>
                        @if(Auth::user()->role === 'admin')
                        <td style="text-align:center;"><div class="action-btn-group" onclick="event.stopPropagation()">
                            <button class="btn-sm-modern btn-edit" onclick="openEdit({{ $d->id }})" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>
                            <button class="btn-sm-modern btn-delete" onclick="confirmDelete({{ $d->id }},'{{ $d->nama_siswa }}')" data-bs-toggle="modal" data-bs-target="#modalConfirm"><i class="bi bi-trash"></i></button>
                        </div></td>
                        @endif
                    </tr>
                    @empty
                    <tr><td colspan="{{ Auth::user()->role === 'admin' ? 10 : 9 }}" style="text-align:center;padding:40px;color:var(--gray);"><i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada data pelanggaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 pagination-modern">{{ $pelanggarans->links() }}</div>
    </div>
</div>

<!-- ======== MODAL DETAIL ======== -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-body p-0">
                <div style="display:flex;min-height:380px;">
                    <!-- KIRI: info -->
                    <div style="flex:1;padding:28px;">
                        <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
                            <div style="width:52px;height:52px;background:#fef2f2;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;"><i class="bi bi-lightning-charge" style="color:#dc2626;"></i></div>
                            <div>
                                <h5 class="fw-bold mb-0" id="dNama">-</h5>
                                <span style="font-size:0.85rem;color:var(--gray);" id="dKelas">-</span>
                                <span class="badge" style="background:#4f46e5;margin-left:6px;" id="dKategori">-</span>
                            </div>
                        </div>
                        <table style="width:100%;">
                            <tr><td style="padding:8px 0;color:var(--gray);font-size:0.85rem;width:130px;">Tanggal</td><td style="padding:8px 0;font-weight:600;" id="dTgl">-</td></tr>
                            <tr><td style="padding:8px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Pelanggaran</td><td style="padding:8px 0;font-weight:600;border-top:1px solid #f1f5f9;" id="dPel">-</td></tr>
                            <tr id="dKeteranganRow"><td style="padding:8px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Keterangan</td><td style="padding:8px 0;font-weight:500;border-top:1px solid #f1f5f9;color:var(--gray);font-size:0.9rem;" id="dKet">-</td></tr>
                            <tr><td style="padding:8px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Poin</td><td style="padding:8px 0;border-top:1px solid #f1f5f9;" id="dPoin"></td></tr>
                            <tr><td style="padding:8px 0;color:var(--gray);font-size:0.85rem;border-top:1px solid #f1f5f9;">Sanksi</td><td style="padding:8px 0;font-weight:600;border-top:1px solid #f1f5f9;" id="dSanksi">-</td></tr>
                        </table>
                    </div>
                    <!-- KANAN: bukti -->
                    <div style="width:320px;flex-shrink:0;background:#fafafa;padding:28px;border-left:1px solid #f1f5f9;display:flex;flex-direction:column;">
                        <small style="color:var(--gray);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Bukti</small>
                        <div id="dFile" class="file-preview-box" style="flex:1;"><div class="file-placeholder">Tidak ada file</div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-3"><button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Tutup</button></div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'admin')
<!-- ======== MODAL CREATE ======== -->
<div class="modal fade modal-custom" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold"><i class="bi bi-plus-lg me-2"></i>Tambah Pelanggaran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="{{ route('Pelanggaran.store') }}" method="POST" enctype="multipart/form-data">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                <select name="nama_siswa" class="form-select" required onchange="fillKelas(this,'cKelas')">
                                    <option value="">-- Pilih --</option>
                                    @foreach($siswaList as $s)<option value="{{ $s->nama_siswa }}" data-kelas="{{ $s->kelas }}">{{ $s->nama_siswa }} ({{ $s->kelas }})</option>@endforeach
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label">Kelas</label><input type="text" id="cKelas" name="kelas" class="form-control" readonly required></div>
                            <div class="mb-3"><label class="form-label">Tanggal <span class="text-danger">*</span></label><input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                            <div class="mb-3"><label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label">Upload Bukti</label><input type="file" name="file" id="cFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this,'cPreview')"><div id="cPreview" class="file-preview-box" style="margin-top:6px;display:none;max-height:150px;overflow:hidden;"></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label class="form-label">Pelanggaran <span class="text-danger">*</span></label><textarea name="pelanggaran" class="form-control" rows="2" required placeholder="Deskripsi pelanggaran"></textarea></div>
                            <div class="mb-3"><label class="form-label">Keterangan <small style="color:var(--gray);">(opsional)</small></label><textarea name="keterangan" class="form-control" rows="2" placeholder="Kronologi atau catatan tambahan"></textarea></div>
                            <div class="mb-3">
                                <label class="form-label">Poin <span class="text-danger">*</span></label>
                                <div class="slider-wrapper">
                                    <input type="range" name="poin" min="1" max="10" step="1" value="5" oninput="var v=this.value;var el=document.getElementById('cPoinL');el.textContent=v;var r=document.getElementById('cPoinRange');if(v<=3){r.style.color='#10b981';r.textContent='Poin: '+v+' (Ringan)';}else if(v<=7){r.style.color='#f59e0b';r.textContent='Poin: '+v+' (Sedang)';}else{r.style.color='#ef4444';r.textContent='Poin: '+v+' (Berat)';}updateSliderBg(this)">
                                    <span class="slider-value" id="cPoinL">5</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:0.75rem;padding:0 2px;margin-top:2px;">
                                    <span style="color:#10b981;font-weight:600;">Ringan</span>
                                    <span style="color:#f59e0b;font-weight:600;">Sedang</span>
                                    <span style="color:#ef4444;font-weight:600;">Berat</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:0.65rem;color:var(--gray);padding:0 2px;">
                                    <span>1 - 3</span><span>4 - 7</span><span>8 - 10</span>
                                </div>
                                <div id="cPoinRange" class="slider-indicator" style="color:#f59e0b;">Poin: 5 (Sedang)</div>
                            </div>
                            <div class="mb-3"><label class="form-label">Sanksi <span class="text-danger">*</span></label><input type="text" name="sanksi" class="form-control" required placeholder="Sanksi yang diberikan"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button><button type="submit" class="btn-primary-modern"><i class="bi bi-save"></i> Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<!-- ======== MODAL EDIT ======== -->
<div class="modal fade modal-custom" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Edit Pelanggaran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="formEdit" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                <select name="nama_siswa" id="eNama" class="form-select" required onchange="fillKelas(this,'eKelas')">
                                    <option value="">-- Pilih --</option>
                                    @foreach($siswaList as $s)<option value="{{ $s->nama_siswa }}" data-kelas="{{ $s->kelas }}">{{ $s->nama_siswa }} ({{ $s->kelas }})</option>@endforeach
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label">Kelas</label><input type="text" id="eKelas" name="kelas" class="form-control" readonly required></div>
                            <div class="mb-3"><label class="form-label">Tanggal <span class="text-danger">*</span></label><input type="date" name="tanggal" id="eTgl" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" id="eKat" class="form-select" required>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label">Upload Bukti</label><input type="file" name="file" id="eFile" class="form-control" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this,'ePreview')"><small id="eFileInfo" style="color:var(--gray);"></small><div id="ePreview" class="file-preview-box" style="margin-top:6px;display:none;max-height:150px;overflow:hidden;"></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label class="form-label">Pelanggaran <span class="text-danger">*</span></label><textarea name="pelanggaran" id="ePel" class="form-control" rows="2" required></textarea></div>
                            <div class="mb-3"><label class="form-label">Keterangan</label><textarea name="keterangan" id="eKet" class="form-control" rows="2"></textarea></div>
                            <div class="mb-3">
                                <label class="form-label">Poin <span class="text-danger">*</span></label>
                                <div class="slider-wrapper">
                                    <input type="range" name="poin" id="ePoinSlider" min="1" max="10" step="1" value="5" oninput="var v=this.value;document.getElementById('ePoinL').textContent=v;var r=document.getElementById('ePoinRange');if(v<=3){r.style.color='#10b981';r.textContent='Poin: '+v+' (Ringan)';}else if(v<=7){r.style.color='#f59e0b';r.textContent='Poin: '+v+' (Sedang)';}else{r.style.color='#ef4444';r.textContent='Poin: '+v+' (Berat)';}updateSliderBg(this)">
                                    <span class="slider-value" id="ePoinL">5</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:0.75rem;padding:0 2px;margin-top:2px;">
                                    <span style="color:#10b981;font-weight:600;">Ringan</span>
                                    <span style="color:#f59e0b;font-weight:600;">Sedang</span>
                                    <span style="color:#ef4444;font-weight:600;">Berat</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:0.65rem;color:var(--gray);padding:0 2px;">
                                    <span>1 - 3</span><span>4 - 7</span><span>8 - 10</span>
                                </div>
                                <div id="ePoinRange" class="slider-indicator" style="color:#f59e0b;">Poin: 5 (Sedang)</div>
                            </div>
                            <div class="mb-3"><label class="form-label">Sanksi <span class="text-danger">*</span></label><input type="text" name="sanksi" id="eSanksi" class="form-control" required></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:500;">Batal</button><button type="submit" class="btn-primary-modern"><i class="bi bi-check-lg"></i> Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function fillKelas(s,t){var o=s.options[s.selectedIndex];document.getElementById(t).value=o?o.dataset.kelas:''}
function previewFile(input,target){
    var el=document.getElementById(target);if(!input.files||!input.files[0]){el.style.display='none';return;}
    var f=input.files[0],ext=f.name.split('.').pop().toLowerCase(),reader=new FileReader();
    el.style.display='block';
    if(ext=='jpg'||ext=='jpeg'||ext=='png'){
        reader.onload=function(e){el.innerHTML='<img src=\"'+e.target.result+'\" style=\"width:100%;max-height:120px;object-fit:contain;border-radius:8px;\">';};
        reader.readAsDataURL(f);
    }else if(ext=='pdf'){
        el.innerHTML='<div style=\"padding:10px;text-align:center;color:var(--gray);font-size:0.85rem;background:#fef2f2;border-radius:8px;\"><i class=\"bi bi-file-earmark-pdf\" style=\"font-size:1.8rem;display:block;margin-bottom:4px;color:#ef4444;\"></i>'+f.name+'</div>';
    }else{el.style.display='none';}
}
function updateSliderBg(slider){
    var v=parseInt(slider.value),pct=((v-1)/9)*100;
    if(v<=3)slider.style.background='linear-gradient(to right, #10b981 '+pct+'%, #e2e8f0 '+pct+'%)';
    else if(v<=7)slider.style.background='linear-gradient(to right, #10b981 33%, #f59e0b '+Math.round((pct-33)*1.5)+'%, #e2e8f0 '+pct+'%)';
    else slider.style.background='linear-gradient(to right, #10b981 33%, #f59e0b 66%, #ef4444 '+Math.round((pct-66)*1.5)+'%, #e2e8f0 '+pct+'%)';
}
document.addEventListener('DOMContentLoaded',function(){
    var cSlide=document.querySelector('.slider-wrapper input[name=poin]');
    if(cSlide){updateSliderBg(cSlide);}
    var eSlide=document.getElementById('ePoinSlider');
    if(eSlide&&!eSlide.value){eSlide.value=5;updateSliderBg(eSlide);}
});
var ds={!! $pelanggarans->map(function($d){return['id'=>$d->id,'nama_siswa'=>$d->nama_siswa,'kelas'=>$d->kelas,'tanggal'=>$d->tanggal,'kategori'=>$d->kategori,'pelanggaran'=>$d->pelanggaran,'keterangan'=>$d->keterangan,'poin'=>$d->poin,'sanksi'=>$d->sanksi,'file'=>$d->file];})->toJson() !!};
function showDetail(id){
    var d=ds.find(function(x){return x.id==id});if(!d)return;
    document.getElementById('dNama').textContent=d.nama_siswa;document.getElementById('dKelas').textContent=d.kelas;
    document.getElementById('dKategori').textContent=d.kategori;document.getElementById('dTgl').textContent=d.tanggal;
    document.getElementById('dPel').textContent=d.pelanggaran;
    var ketRow=document.getElementById('dKeteranganRow');
    if(d.keterangan){ketRow.style.display='';document.getElementById('dKet').textContent=d.keterangan;}
    else ketRow.style.display='none';
    var s='';for(var i=1;i<=10;i++)s+=i<=d.poin?'<i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;font-size:0.85rem;"></i> ':'<i class="bi bi-exclamation-triangle" style="color:#ddd;font-size:0.85rem;"></i> ';
    document.getElementById('dPoin').innerHTML='<span style="font-weight:700;">'+d.poin+'/10</span> '+s;
    document.getElementById('dSanksi').textContent=d.sanksi;
    var f=document.getElementById('dFile');
    if(d.file){
        var ext=d.file.split('.').pop().toLowerCase();
        if(ext=='jpg'||ext=='jpeg'||ext=='png')f.innerHTML='<img src="/storage/'+d.file+'" alt="Bukti" style="width:100%;max-height:200px;object-fit:contain;display:block;background:#f8fafc;">';
        else if(ext=='pdf')f.innerHTML='<iframe src="/storage/'+d.file+'" style="width:100%;height:200px;border:none;"></iframe>';
        else f.innerHTML='<div class="file-placeholder"><a href="/storage/'+d.file+'" target="_blank" style="color:var(--primary);font-weight:600;">Download file</a></div>';
    } else f.innerHTML='<div class="file-placeholder">Tidak ada file</div>';
}
function openEdit(id){
    var d=ds.find(function(x){return x.id==id});if(!d)return;
    document.getElementById('formEdit').action='/pelanggaran/'+id;
    var fields={eNama:'nama_siswa',eKelas:'kelas',eTgl:'tanggal',eKat:'kategori',ePel:'pelanggaran',eKet:'keterangan',eSanksi:'sanksi'};
    for(var k in fields)document.getElementById(k).value=d[fields[k]];
    var el=document.getElementById('ePoinSlider');el.value=d.poin;
    var v=d.poin;document.getElementById('ePoinL').textContent=v;var r=document.getElementById('ePoinRange');if(v<=3){r.style.color='#10b981';r.textContent='Poin: '+v+' (Ringan)';}else if(v<=7){r.style.color='#f59e0b';r.textContent='Poin: '+v+' (Sedang)';}else{r.style.color='#ef4444';r.textContent='Poin: '+v+' (Berat)';}
    updateSliderBg(el);
    var fi=document.getElementById('eFileInfo');
    if(d.file){
        var ext=d.file.split('.').pop().toLowerCase();
        if(ext=='jpg'||ext=='jpeg'||ext=='png'){fi.innerHTML='<img src=\"/storage/'+d.file+'\" style=\"width:100%;max-height:120px;object-fit:contain;border-radius:8px;margin-top:4px;\">';}
        else if(ext=='pdf'){fi.innerHTML='<div style=\"padding:8px;text-align:center;background:#fef2f2;border-radius:8px;margin-top:4px;\"><i class=\"bi bi-file-earmark-pdf\" style=\"color:#ef4444;font-size:1.5rem;display:block;margin-bottom:2px;\"></i>'+d.file+'</div>';}
        else{fi.innerHTML='<i class=\"bi bi-paperclip\"></i> File: '+d.file+'';}
    }else{fi.innerHTML='';}
}
</script>
@endif

<!-- ======== MODAL CONFIRM DELETE ======== -->
<div class="modal fade" id="modalConfirm" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-body text-center py-4">
                <div style="width:60px;height:60px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;"><i class="bi bi-trash3" style="color:#ef4444;font-size:1.8rem;"></i></div>
                <h6 class="fw-bold mb-2">Konfirmasi Hapus</h6>
                <p class="mb-0" style="color:var(--gray);font-size:0.85rem;">Yakin ingin menghapus data <strong id="confirmName"></strong>?</p>
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
function confirmDelete(i,n){document.getElementById('confirmName').textContent=n;document.getElementById('formDelete').action='/pelanggaran/'+i;}
</script>
@endsection