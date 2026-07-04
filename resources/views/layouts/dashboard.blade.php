<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - BK SMP</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #eef2ff;
            --secondary: #0ea5e9;
            --accent: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --sidebar-width: 260px;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 800;
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 0;
            transition: all 0.2s;
            text-decoration: none;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--accent);
        }

        .sidebar .nav-link i { font-size: 1.1rem; width: 24px; text-align: center; }

        .sidebar .nav-divider {
            color: rgba(255,255,255,0.3);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 20px 8px;
            font-weight: 600;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-footer form { margin: 0; }

        .sidebar-footer .btn-logout {
            color: rgba(255,255,255,0.5);
            background: none;
            border: none;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 8px 0;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: color 0.2s;
        }

        .sidebar-footer .btn-logout:hover { color: var(--danger); }

        /* ── Main Content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* ── Topbar ── */
        .topbar {
            background: #fff;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar h5 {
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
            font-size: 0.85rem;
        }

        .topbar .user-info i { font-size: 1.8rem; color: var(--primary); }

        /* ── Content ── */
        .page-content {
            padding: 24px 30px;
        }

        /* ── Cards Modern ── */
        .card-modern {
            background: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* ── Stat Cards ── */
        .stat-card {
            border-radius: 16px;
            padding: 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 16px;
            top: 16px;
            font-size: 3rem;
            opacity: 0.2;
        }

        .stat-card h6 {
            font-weight: 500;
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .stat-card h2 {
            font-weight: 800;
            font-size: 2rem;
            margin: 0;
        }

        .stat-purple { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .stat-blue { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
        .stat-green { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-orange { background: linear-gradient(135deg, #f59e0b, #d97706); }

        /* ── Tables ── */
        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }

        .table-modern thead th {
            background: var(--gray-light);
            padding: 12px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
            border-bottom: 2px solid #e2e8f0;
        }

        .table-modern tbody td {
            padding: 14px 16px;
            font-size: 0.9rem;
            color: var(--dark);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-modern tbody tr:hover { background: #f8fafc; }

        /* ── Buttons ── */
        .btn-primary-modern {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-modern:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }

        .btn-success-modern {
            background: var(--success);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success-modern:hover {
            background: #059669;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-edit { background: #3b82f6; }
        .btn-edit:hover { background: #2563eb; }
        .btn-delete { background: var(--danger); }
        .btn-delete:hover { background: #dc2626; }
        .btn-pdf { background: var(--success); }

        .btn-sm-modern {
            padding: 6px 14px;
            border-radius: 8px;
            border: none;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-sm-modern:hover { transform: translateY(-1px); }

        /* ── Forms ── */
        .form-modern {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
        }

        .form-modern .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .form-modern .form-control,
        .form-modern .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-modern .form-control:focus,
        .form-modern .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .form-modern textarea.form-control { resize: vertical; min-height: 100px; }

        /* ── Alert ── */
        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 500;
        }

        .alert-modern.alert-success {
            background: #ecfdf5;
            color: #065f46;
        }

        .alert-modern.alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        /* ── Drag-drop area ── */
        .drop-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8fafc;
        }

        .drop-zone:hover,
        .drop-zone.active {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .drop-zone p { margin: 0; color: var(--gray); font-size: 0.9rem; }
        .drop-zone .file-name { font-weight: 600; color: var(--primary); margin-top: 8px; }

        /* ── Pagination ── */
        .pagination-modern .page-link {
            border: none;
            padding: 8px 16px;
            margin: 0 2px;
            border-radius: 8px;
            color: var(--gray);
            font-weight: 500;
        }

        .pagination-modern .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
        }

        .pagination-modern .page-link:hover {
            background: var(--gray-light);
            color: var(--dark);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                overflow: hidden;
            }
            .sidebar:hover { width: var(--sidebar-width); }
            .sidebar-brand h4, .sidebar-brand small,
            .sidebar .nav-link span, .sidebar .nav-divider,
            .sidebar-footer span { display: none; }
            .sidebar:hover .sidebar-brand h4,
            .sidebar:hover .sidebar-brand small,
            .sidebar:hover .sidebar .nav-link span,
            .sidebar:hover .sidebar .nav-divider,
            .sidebar:hover .sidebar-footer span { display: block; }
            .main-content { margin-left: 60px; }
            .page-content { padding: 16px; }
            .topbar { padding: 12px 16px; }
        }

        /* ── Toast notifications ── */
        .toast-container-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        }

        .toast-custom {
            min-width: 320px;
            background: #fff;
            border-radius: 14px;
            padding: 16px 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            border-left: 4px solid var(--success);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            animation: slideIn 0.3s ease;
        }

        .toast-custom.error {
            border-left-color: var(--danger);
        }

        .toast-custom .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .toast-custom .toast-icon.success {
            background: #ecfdf5;
            color: #059669;
        }

        .toast-custom .toast-icon.error {
            background: #fef2f2;
            color: #dc2626;
        }

        .toast-custom .toast-msg {
            flex: 1;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--dark);
        }

        .toast-custom .toast-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateX(100%); }
        }

        /* ── Modal styling ── */
        .modal-custom .modal-header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            border-radius: 16px 16px 0 0;
            padding: 20px 24px;
        }

        .modal-custom .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-custom .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .modal-custom .modal-body {
            padding: 24px;
        }

        .modal-custom .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #e2e8f0;
        }

        .modal-backdrop.show {
            opacity: 0.5;
        }
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            padding: 24px 32px;
            color: #fff;
            margin-bottom: 24px;
        }

        .welcome-banner h4 {
            font-weight: 700;
            margin: 0;
        }

        .welcome-banner p {
            opacity: 0.85;
            margin: 4px 0 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-shield-check"></i> BK App</h4>
        <small>SMA Koperasi Pontianak</small>
    </div>

    <div class="nav-divider">Menu</div>

    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('Siswa.index') }}" class="nav-link {{ request()->routeIs('Siswa.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Siswa</span>
    </a>
    <a href="{{ route('Pelanggaran.index') }}" class="nav-link {{ request()->routeIs('Pelanggaran.*') ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Pelanggaran</span>
    </a>
    @if(Auth::user()->role === 'admin')
    <div class="nav-divider">Pengaturan</div>
    <a href="{{ route('User.index') }}" class="nav-link {{ request()->routeIs('User.*') ? 'active' : '' }}">
        <i class="bi bi-gear"></i>
        <span>Manajemen Akun</span>
    </a>
    @endif

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span> Keluar</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar">
        <h5>@yield('title', 'Dashboard')</h5>
        <div class="user-info">
            <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            <span class="badge" style="background:{{ Auth::user()->role === 'admin' ? '#4f46e5' : '#10b981' }}; border-radius:20px; padding:2px 12px; font-weight:500;">
                {{ ucfirst(Auth::user()->role ?? 'user') }}
            </span>
            <i class="bi bi-person-circle"></i>
        </div>
    </div>

    <div class="page-content">
        @yield('content')
    </div>

    <!-- Toast Container -->
    <div class="toast-container-custom" id="toastContainer">
        @if(session('success'))
            <div class="toast-custom" id="toastSuccess">
                <div class="toast-icon success"><i class="bi bi-check-lg"></i></div>
                <span class="toast-msg">{{ session('success') }}</span>
                <button class="toast-close" onclick="dismissToast('toastSuccess')">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="toast-custom error" id="toastError">
                <div class="toast-icon error"><i class="bi bi-x-lg"></i></div>
                <span class="toast-msg">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </span>
                <button class="toast-close" onclick="dismissToast('toastError')">&times;</button>
            </div>
        @endif
    </div>

    <script>
    function dismissToast(id) {
        var el = document.getElementById(id);
        if (el) {
            el.style.animation = 'fadeOut 0.3s ease forwards';
            setTimeout(function() { el.remove(); }, 300);
        }
    }
    // Auto-dismiss after 4s
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('.toast-custom').forEach(function(el) {
                el.style.animation = 'fadeOut 0.3s ease forwards';
                setTimeout(function() { el.remove(); }, 300);
            });
        }, 4000);
    });
    </script>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
