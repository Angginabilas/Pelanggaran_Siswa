@extends('layouts.dashboard')

@section('title', 'Manajemen Akun')

@section('content')
<div class="card-modern">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1" style="color:var(--dark);">
                    <i class="bi bi-gear" style="color:var(--primary);"></i> Manajemen Akun
                </h5>
                <small style="color:var(--gray);">Kelola akun pengguna sistem</small>
            </div>
            <button class="btn-primary-modern" data-bs-toggle="modal" data-bs-target="#modalUserCreate">
                <i class="bi bi-plus-lg"></i> Tambah Akun
            </button>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $u->name }}</strong></td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role === 'admin')
                                    <span class="badge" style="background:#4f46e5;">Admin</span>
                                @else
                                    <span class="badge" style="background:#10b981;">User</span>
                                @endif
                            </td>
                            <td>{{ $u->created_at->format('d/m/Y') }}</td>
                            <td style="text-align:center;">
                                <button class="btn-sm-modern btn-edit"
                                        onclick="openEditUser({{ $u->id }})"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalUserEdit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @if($u->id !== Auth::user()->id)
                                <button class="btn-sm-modern btn-delete"
                                        onclick="confirmDelete('users', {{ $u->id }}, '{{ $u->name }}')"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalConfirmDelete">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:var(--gray);">
                                <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                                Belum ada akun
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 pagination-modern">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- ─── MODAL CREATE USER ─── -->
<div class="modal fade modal-custom" id="modalUserCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('User.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Nama pengguna">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="email@contoh.com">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required min="6" placeholder="Min. 6 karakter">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="">— Pilih —</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
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

<!-- ─── MODAL EDIT USER ─── -->
<div class="modal fade modal-custom" id="modalUserEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil me-2"></i>Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editUserName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="editUserEmail" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" min="6" placeholder="Kosongkan jika tidak ganti">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="editUserRole" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
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
var userDataStore = {!! $users->map(function($u) {
    return [
        'id' => $u->id,
        'name' => $u->name,
        'email' => $u->email,
        'role' => $u->role,
    ];
})->toJson() !!};

function openEditUser(id) {
    var data = userDataStore.find(function(u) { return u.id == id; });
    if (!data) return;

    document.getElementById('formEditUser').action = '/users/' + id;
    document.getElementById('editUserName').value = data.name;
    document.getElementById('editUserEmail').value = data.email;
    document.getElementById('editUserRole').value = data.role;
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
                    Yakin ingin menghapus akun <strong id="deleteItemName"></strong>?
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
function confirmDelete(type, id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('formDelete').action = '/' + type + '/' + id;
}
</script>
@endsection
