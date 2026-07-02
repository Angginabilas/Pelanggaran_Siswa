<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard BK</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ChartJS (opsional untuk grafik) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #9cc7f2;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .profile i {
            font-size: 50px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #000;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #7fb0e3;
        }

        /* Main content */
        .main-content {
            margin-left: 240px;
            width: 100%;
        }

        /* Topbar */
        .topbar {
            height: 60px;
            border-bottom: 1px solid #ccc;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
        }

        .welcome-box {
            background-color: #6f9fa8;
            color: #000;
            padding: 10px;
            margin: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="profile">
        <i class="bi bi-person-circle"></i>
        <p>Admin</p>
    </div>

    <a href="{{ route('dashboard') }}"><i class="bi bi-house"></i> Beranda</a>
    <a href="{{ route('Siswa.index') }}"><i class="bi bi-people"></i> Siswa</a>
    <a href="{{ route('Pelanggaran.index') }}"><i class="bi bi-exclamation-triangle"></i> Pelanggaran</a>
    <a href="{{ route('CatatanPelanggaran.index') }}"><i class="bi bi-journal-text"></i> Catatan Pelanggaran</a>
    <form action="{{ route('logout') }}" method="POST" class="mt-5">
    @csrf
    <button type="submit" class="btn btn-link text-decoration-none">
        <i class="bi bi-box-arrow-right"></i> LogOut
    </button>
</form>

</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
        <div>
           Admin <i class="bi bi-person-circle"></i>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid px-4 mt-4">
        @yield('content')
    </div>
</div>

</body>
</html>
