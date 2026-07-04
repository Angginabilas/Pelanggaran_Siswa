@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <h4><i class="bi bi-hand-wave me-2"></i> Selamat Datang, Admin!</h4>
        <p>Pantau dan kelola data pelanggaran siswa dengan mudah.</p>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card stat-purple">
                <i class="bi bi-people stat-icon"></i>
                <h6><i class="bi bi-people me-1"></i> Total Siswa</h6>
                <h2>{{ $totalSiswa ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-blue">
                <i class="bi bi-exclamation-triangle stat-icon"></i>
                <h6><i class="bi bi-exclamation-triangle me-1"></i> Total Pelanggaran</h6>
                <h2>{{ $totalPelanggaran ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-orange">
                <i class="bi bi-star stat-icon"></i>
                <h6><i class="bi bi-star me-1"></i> Total Poin</h6>
                <h2>{{ $totalPoin ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card-modern">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3" style="color:var(--dark);">
                <i class="bi bi-bar-chart-fill me-2" style="color:var(--primary);"></i>
                Grafik Pelanggaran Berdasarkan Kategori
            </h5>
            <canvas id="kategoriChart" height="100"></canvas>
        </div>
    </div>

    <script>
        const kategoriData = @json($kategoriData ?? []);
        const labels = Object.keys(kategoriData);
        const data = Object.values(kategoriData);

        const colors = ['#6366f1', '#0ea5e9', '#f59e0b', '#10b981', '#ef4444'];

        new Chart(document.getElementById('kategoriChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
@endsection
