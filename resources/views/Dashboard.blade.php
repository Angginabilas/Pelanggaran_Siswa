<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard BK</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background-color: #9cc7f2;
            position: fixed; left: 0; top: 0;
            padding-top: 20px;
        }
        .sidebar .profile { text-align: center; margin-bottom: 30px; }
        .sidebar .profile i { font-size: 50px; }
        .sidebar a { display: block; padding: 12px 20px; color: #000; text-decoration: none; font-weight: 500; }
        .sidebar a:hover { background-color: #7fb0e3; }
        .main-content { margin-left: 240px; }
        .topbar {
            height: 60px;
            border-bottom: 1px solid #ccc;
            padding: 10px 20px;
            display: flex; justify-content: space-between; align-items: center;
            background-color: #fff;
        }
        .welcome-box { background-color: #6f9fa8; color: #000; padding: 10px; margin: 20px; text-align: center; font-weight: bold; }
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
        <h5 class="mb-0">Dashboard</h5>
        <div>Admin <i class="bi bi-person-circle"></i></div>
    </div>

    <!-- Welcome -->
    <div class="welcome-box">
        Selamat Datang, Admin
    </div>

    <!-- Dashboard Content -->
    <div class="container-fluid px-4">

        <!-- Statistik -->
        <div class="row text-center mb-4">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5>Jenis Pelanggaran</h5>
                        <h2>{{ $totalPelanggaran }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5>Catatan Pelanggaran</h5>
                        <h2>{{ $totalCatatan }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5>Sanksi</h5>
                        <h2>{{ $totalPoin }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="text-center mb-3">Grafik Pelanggaran Berdasarkan Kategori</h5>
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
    // Pastikan kategoriData selalu object/array
    const kategoriData = @json($kategoriData ?? []);

    // Jika kategoriData bukan object, fallback ke array kosong
    const labels = (kategoriData && typeof kategoriData === 'object') ? Object.keys(kategoriData) : [];
    const data = (kategoriData && typeof kategoriData === 'object') ? Object.values(kategoriData) : [];

    new Chart(document.getElementById('kategoriChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: data,
                backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>


</body>
</html>
