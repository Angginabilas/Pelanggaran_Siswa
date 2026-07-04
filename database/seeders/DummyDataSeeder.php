<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\CatatanPelanggaran;
use App\Models\Sanksi;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // ========== 1. AKUN PENGGUNA ==========
        // Hapus user lama dulu biar clean, kecuali kalo udah ada jangan duplikat
        User::whereNotIn('email', ['admin@admin.com', 'user@user.com'])->delete();

        // Admin default
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin BK',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );
        echo "  ✓ User admin: admin@admin.com / admin123\n";

        // User biasa default
        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Guru BK',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]
        );
        echo "  ✓ User guru: user@user.com / user123\n";

        // Tambahan user
        $extraUsers = [
            ['name' => 'Kepala Sekolah', 'email' => 'kepsek@sekolah.com', 'password' => bcrypt('kepsek123'), 'role' => 'admin'],
            ['name' => 'Wali Kelas X IPA 1', 'email' => 'walas10ipa1@sekolah.com', 'password' => bcrypt('walas123'), 'role' => 'user'],
            ['name' => 'Wali Kelas XI IPS 2', 'email' => 'walas11ips2@sekolah.com', 'password' => bcrypt('walas123'), 'role' => 'user'],
            ['name' => 'Wali Kelas XII IPA 3', 'email' => 'walas12ipa3@sekolah.com', 'password' => bcrypt('walas123'), 'role' => 'user'],
        ];
        foreach ($extraUsers as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
        echo "  ✓ Tambahan " . count($extraUsers) . " user\n";

        // ========== 2. DATA SANKSI ==========
        Sanksi::truncate(); // reset biar rapi
        $sanksiData = [
            ['nama_sanksi' => 'Teguran Lisan', 'deskripsi' => 'Peringatan secara lisan oleh guru BK', 'poin' => 5],
            ['nama_sanksi' => 'Teguran Tertulis', 'deskripsi' => 'Surat peringatan resmi yang dicatat', 'poin' => 15],
            ['nama_sanksi' => 'Skorsing Ringan', 'deskripsi' => 'Tidak boleh masuk sekolah 1-3 hari', 'poin' => 30],
            ['nama_sanksi' => 'Skorsing Berat', 'deskripsi' => 'Tidak boleh masuk sekolah 4-7 hari', 'poin' => 45],
            ['nama_sanksi' => 'Dikembalikan ke Orang Tua', 'deskripsi' => 'Dikembalikan ke orang tua untuk pembinaan lanjutan', 'poin' => 60],
            ['nama_sanksi' => 'Dikeluarkan dari Sekolah', 'deskripsi' => 'Sanksi tertinggi: dikeluarkan dari sekolah', 'poin' => 100],
        ];
        foreach ($sanksiData as $s) {
            Sanksi::create($s);
        }
        echo "  ✓ " . count($sanksiData) . " data sanksi\n";

        // ========== 3. DATA SISWA ==========
        // Hapus siswa test
        Siswa::where('nama_siswa', 'like', '%Test%')->orWhere('nama_siswa', 'like', '%anggi%')->delete();

        $siswaList = [
            // Kelas X IPA 1
            ['nama_siswa' => 'Ahmad Fauzi', 'kelas' => 'X IPA 1', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Jl. Merdeka No. 10, Malang'],
            ['nama_siswa' => 'Siti Nurhaliza', 'kelas' => 'X IPA 1', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Sudirman No. 5, Malang'],
            ['nama_siswa' => 'Rizky Pratama', 'kelas' => 'X IPA 1', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Perumahan Griya Asri Blok A3, Malang'],
            ['nama_siswa' => 'Dinda Aulia Putri', 'kelas' => 'X IPA 1', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Ijen No. 25, Malang'],
            ['nama_siswa' => 'Fajar Ramadhan', 'kelas' => 'X IPA 1', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Ds. Tawangmangu RT 02 RW 05, Malang'],

            // Kelas X IPA 2
            ['nama_siswa' => 'Nadia Safitri', 'kelas' => 'X IPA 2', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Bromo No. 7, Malang'],
            ['nama_siswa' => 'Dimas Ardiansyah', 'kelas' => 'X IPA 2', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Perum Bumi Indah Blok C5, Malang'],
            ['nama_siswa' => 'Cantika Dewi', 'kelas' => 'X IPA 2', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Panglima Sudirman No. 88, Malang'],

            // Kelas XI IPA 1
            ['nama_siswa' => 'Bayu Aji Wicaksono', 'kelas' => 'XI IPA 1', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Jl. Veteran No. 12, Malang'],
            ['nama_siswa' => 'Putri Ayu Lestari', 'kelas' => 'XI IPA 1', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Perum Villa Bukit Tidar Blok D2, Malang'],
            ['nama_siswa' => 'Hendra Gunawan', 'kelas' => 'XI IPA 1', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Jl. Danau Toba No. 3, Malang'],

            // Kelas XI IPS 2
            ['nama_siswa' => 'Budi Santoso', 'kelas' => 'XI IPS 2', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Jl. Ahmad Yani No. 20, Malang'],
            ['nama_siswa' => 'Dewi Sartika', 'kelas' => 'XI IPS 2', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Diponegoro No. 8, Malang'],
            ['nama_siswa' => 'Agus Setiawan', 'kelas' => 'XI IPS 2', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Jl. Pahlawan No. 17, Malang'],
            ['nama_siswa' => 'Rina Marlina', 'kelas' => 'XI IPS 2', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Perum Permata Hijau Blok E1, Malang'],

            // Kelas XII IPA 3
            ['nama_siswa' => 'Rudi Hartono', 'kelas' => 'XII IPA 3', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Jl. Gajah Mada No. 15, Malang'],
            ['nama_siswa' => 'Mega Wulandari', 'kelas' => 'XII IPA 3', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Sumatra No. 22, Malang'],
            ['nama_siswa' => 'Doni Prasetyo', 'kelas' => 'XII IPA 3', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Ds. Landungsari RT 05 RW 02, Malang'],

            // Kelas XII IPS 1
            ['nama_siswa' => 'Indah Permata Sari', 'kelas' => 'XII IPS 1', 'jenis_kelamin' => 'Perempuan', 'alamat_siswa' => 'Jl. Kalimantan No. 45, Malang'],
            ['nama_siswa' => 'Aditya Nugraha', 'kelas' => 'XII IPS 1', 'jenis_kelamin' => 'Laki-laki', 'alamat_siswa' => 'Perum Graha Kencana Blok F8, Malang'],
        ];

        foreach ($siswaList as $s) {
            Siswa::create($s);
        }
        echo "  ✓ " . count($siswaList) . " data siswa\n";

        // Update total_poin siswa berdasarkan data pelanggaran nanti (refresh)
        Siswa::query()->update(['total_poin' => 0]);

        // ========== 4. DATA PELANGGARAN ==========
        Pelanggaran::truncate();

        $pelanggaranList = [
            // Ahmad Fauzi — sering terlambat
            ['nama_siswa' => 'Ahmad Fauzi', 'kelas' => 'X IPA 1', 'tanggal' => '2026-01-10', 'kategori' => 'Ringan', 'pelanggaran' => 'Terlambat masuk sekolah 15 menit', 'keterangan' => 'Datang jam 07.15, tidak membawa surat izin', 'poin' => 3, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Ahmad Fauzi', 'kelas' => 'X IPA 1', 'tanggal' => '2026-02-05', 'kategori' => 'Ringan', 'pelanggaran' => 'Tidak memakai sepatu hitam', 'keterangan' => 'Memakai sepatu warna putih', 'poin' => 2, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Ahmad Fauzi', 'kelas' => 'X IPA 1', 'tanggal' => '2026-03-20', 'kategori' => 'Ringan', 'pelanggaran' => 'Membuang sampah sembarangan', 'keterangan' => 'Kedapatan membuang sampah plastik di selokan belakang kelas', 'poin' => 2, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Ahmad Fauzi', 'kelas' => 'X IPA 1', 'tanggal' => '2026-05-12', 'kategori' => 'Sedang', 'pelanggaran' => 'Membolos jam pelajaran', 'keterangan' => 'Tidak masuk kelas selama 2 jam pelajaran, diketahui sedang di kantin', 'poin' => 6, 'sanksi' => 'Teguran Tertulis'],

            // Siti Nurhaliza
            ['nama_siswa' => 'Siti Nurhaliza', 'kelas' => 'X IPA 1', 'tanggal' => '2026-02-18', 'kategori' => 'Ringan', 'pelanggaran' => 'Berkuku panjang', 'keterangan' => 'Kuku melebihi batas yang ditentukan', 'poin' => 1, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Siti Nurhaliza', 'kelas' => 'X IPA 1', 'tanggal' => '2026-04-08', 'kategori' => 'Ringan', 'pelanggaran' => 'Membawa handphone saat jam pelajaran', 'keterangan' => 'HP digunakan saat guru sedang menjelaskan', 'poin' => 3, 'sanksi' => 'Teguran Lisan'],

            // Budi Santoso
            ['nama_siswa' => 'Budi Santoso', 'kelas' => 'XI IPS 2', 'tanggal' => '2026-01-20', 'kategori' => 'Sedang', 'pelanggaran' => 'Berkelahi dengan teman sekelas', 'keterangan' => 'Terlibat perkelahian di belakang kelas saat jam istirahat', 'poin' => 8, 'sanksi' => 'Teguran Tertulis'],
            ['nama_siswa' => 'Budi Santoso', 'kelas' => 'XI IPS 2', 'tanggal' => '2026-03-15', 'kategori' => 'Ringan', 'pelanggaran' => 'Merokok di lingkungan sekolah', 'keterangan' => 'Kedapatan merokok di toilet bersama 2 temannya', 'poin' => 5, 'sanksi' => 'Teguran Tertulis'],

            // Dewi Sartika
            ['nama_siswa' => 'Dewi Sartika', 'kelas' => 'XI IPS 2', 'tanggal' => '2026-02-22', 'kategori' => 'Ringan', 'pelanggaran' => 'Tidak mengerjakan PR 3 mata pelajaran', 'keterangan' => 'PR Matematika, Bahasa Inggris, dan Fisika tidak dikerjakan', 'poin' => 3, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Dewi Sartika', 'kelas' => 'XI IPS 2', 'tanggal' => '2026-05-05', 'kategori' => 'Ringan', 'pelanggaran' => 'Berambut panjang tidak diikat', 'keterangan' => 'Melanggar tata tertib kerapihan rambut', 'poin' => 1, 'sanksi' => 'Teguran Lisan'],

            // Rudi Hartono
            ['nama_siswa' => 'Rudi Hartono', 'kelas' => 'XII IPA 3', 'tanggal' => '2026-01-28', 'kategori' => 'Berat', 'pelanggaran' => 'Membawa senjata tajam', 'keterangan' => 'Kedapatan membawa pisau lipat di tas', 'poin' => 10, 'sanksi' => 'Skorsing'],
            ['nama_siswa' => 'Rudi Hartono', 'kelas' => 'XII IPA 3', 'tanggal' => '2026-02-20', 'kategori' => 'Sedang', 'pelanggaran' => 'Mengejek dan menghina teman', 'keterangan' => 'Mengolok-olok teman secara verbal hingga menangis', 'poin' => 6, 'sanksi' => 'Teguran Tertulis'],
            ['nama_siswa' => 'Rudi Hartono', 'kelas' => 'XII IPA 3', 'tanggal' => '2026-05-10', 'kategori' => 'Sedang', 'pelanggaran' => 'Membolos 3 hari berturut-turut', 'keterangan' => 'Tidak masuk tanpa keterangan selama 3 hari', 'poin' => 8, 'sanksi' => 'Teguran Tertulis'],

            // Rizky Pratama
            ['nama_siswa' => 'Rizky Pratama', 'kelas' => 'X IPA 1', 'tanggal' => '2026-03-02', 'kategori' => 'Ringan', 'pelanggaran' => 'Seragam tidak dimasukkan', 'keterangan' => 'Baju seragam dikeluarkan saat jam pelajaran', 'poin' => 1, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Rizky Pratama', 'kelas' => 'X IPA 1', 'tanggal' => '2026-04-14', 'kategori' => 'Ringan', 'pelanggaran' => 'Berisik di kelas saat jam pelajaran', 'keterangan' => 'Mengganggu teman dan membuat gaduh', 'poin' => 2, 'sanksi' => 'Teguran Lisan'],

            // Dimas Ardiansyah
            ['nama_siswa' => 'Dimas Ardiansyah', 'kelas' => 'X IPA 2', 'tanggal' => '2026-03-10', 'kategori' => 'Sedang', 'pelanggaran' => 'Membawa mainan ke sekolah', 'keterangan' => 'Membawa dan memainkan kartu remi saat jam pelajaran', 'poin' => 4, 'sanksi' => 'Teguran Lisan'],

            // Bayu Aji Wicaksono
            ['nama_siswa' => 'Bayu Aji Wicaksono', 'kelas' => 'XI IPA 1', 'tanggal' => '2026-02-14', 'kategori' => 'Ringan', 'pelanggaran' => 'Tidak memakai dasi', 'keterangan' => 'Datang ke sekolah tanpa dasi', 'poin' => 2, 'sanksi' => 'Teguran Lisan'],
            ['nama_siswa' => 'Bayu Aji Wicaksono', 'kelas' => 'XI IPA 1', 'tanggal' => '2026-06-01', 'kategori' => 'Sedang', 'pelanggaran' => 'Ketahuan mencontek saat ujian', 'keterangan' => 'Membawa contekan di atas meja saat ujian semester', 'poin' => 7, 'sanksi' => 'Teguran Tertulis'],

            // Agus Setiawan
            ['nama_siswa' => 'Agus Setiawan', 'kelas' => 'XI IPS 2', 'tanggal' => '2026-04-22', 'kategori' => 'Sedang', 'pelanggaran' => 'Memalak teman', 'keterangan' => 'Meminta uang secara paksa kepada adik kelas', 'poin' => 8, 'sanksi' => 'Teguran Tertulis'],
            ['nama_siswa' => 'Agus Setiawan', 'kelas' => 'XI IPS 2', 'tanggal' => '2026-05-28', 'kategori' => 'Berat', 'pelanggaran' => 'Terlibat perkelahian antar sekolah', 'keterangan' => 'Berkelahi dengan siswa dari sekolah lain sepulang sekolah', 'poin' => 10, 'sanksi' => 'Skorsing'],

            // Doni Prasetyo
            ['nama_siswa' => 'Doni Prasetyo', 'kelas' => 'XII IPA 3', 'tanggal' => '2026-04-05', 'kategori' => 'Ringan', 'pelanggaran' => 'Rambut tidak rapi dan panjang', 'keterangan' => 'Rambut melebihi kerah baju', 'poin' => 2, 'sanksi' => 'Teguran Lisan'],

            // Aditya Nugraha
            ['nama_siswa' => 'Aditya Nugraha', 'kelas' => 'XII IPS 1', 'tanggal' => '2026-01-15', 'kategori' => 'Sedang', 'pelanggaran' => 'Ketahuan minum-minuman keras', 'keterangan' => 'Kedapatan membawa dan meminum minuman keras di lingkungan sekolah', 'poin' => 10, 'sanksi' => 'Skorsing'],
        ];

        foreach ($pelanggaranList as $p) {
            Pelanggaran::create($p);
        }
        echo "  ✓ " . count($pelanggaranList) . " data pelanggaran\n";

        // ========== 5. DATA CATATAN PELANGGARAN ==========
        CatatanPelanggaran::truncate();

        $catatanList = [
            [
                'nama_siswa' => 'Ahmad Fauzi',
                'kelas' => 'X IPA 1',
                'jenis_pelanggaran' => 'Keterlambatan',
                'tanggal' => '2026-01-10',
                'keterangan' => 'Terlambat 15 menit. Sudah ditegur dan diberi pembinaan.',
                'poin' => 3,
                'sanksi' => 'Teguran Lisan',
            ],
            [
                'nama_siswa' => 'Ahmad Fauzi',
                'kelas' => 'X IPA 1',
                'jenis_pelanggaran' => 'Membolos',
                'tanggal' => '2026-05-12',
                'keterangan' => 'Membolos jam pelajaran Matematika dan Bahasa Indonesia. Orang tua sudah dihubungi.',
                'poin' => 6,
                'sanksi' => 'Teguran Tertulis',
            ],
            [
                'nama_siswa' => 'Budi Santoso',
                'kelas' => 'XI IPS 2',
                'jenis_pelanggaran' => 'Perkelahian',
                'tanggal' => '2026-01-20',
                'keterangan' => 'Terlibat perkelahian dengan teman sekelas karena masalah saling ejek. Pembinaan dilakukan dan orang tua dipanggil.',
                'poin' => 8,
                'sanksi' => 'Teguran Tertulis',
            ],
            [
                'nama_siswa' => 'Rudi Hartono',
                'kelas' => 'XII IPA 3',
                'jenis_pelanggaran' => 'Senjata Tajam',
                'tanggal' => '2026-01-28',
                'keterangan' => 'Kedapatan membawa pisau lipat ke sekolah. Orang tua dipanggil dan siswa diskors 3 hari.',
                'poin' => 10,
                'sanksi' => 'Skorsing Ringan',
            ],
            [
                'nama_siswa' => 'Siti Nurhaliza',
                'kelas' => 'X IPA 1',
                'jenis_pelanggaran' => 'Handphone',
                'tanggal' => '2026-04-08',
                'keterangan' => 'Kedapatan menggunakan HP saat jam pelajaran berlangsung. HP disita dan dikembalikan ke orang tua.',
                'poin' => 3,
                'sanksi' => 'Teguran Lisan',
            ],
            [
                'nama_siswa' => 'Agus Setiawan',
                'kelas' => 'XI IPS 2',
                'jenis_pelanggaran' => 'Perkelahian',
                'tanggal' => '2026-05-28',
                'keterangan' => 'Terlibat perkelahian dengan siswa SMK Nusantara sepulang sekolah. Kasus ditangani oleh BK dan wali kelas.',
                'poin' => 10,
                'sanksi' => 'Skorsing',
            ],
            [
                'nama_siswa' => 'Bayu Aji Wicaksono',
                'kelas' => 'XI IPA 1',
                'jenis_pelanggaran' => 'Mencontek',
                'tanggal' => '2026-06-01',
                'keterangan' => 'Kedapatan membawa contekan saat ujian semester genap. Nilai ujian yang bersangkutan digugurkan.',
                'poin' => 7,
                'sanksi' => 'Teguran Tertulis',
            ],
            [
                'nama_siswa' => 'Aditya Nugraha',
                'kelas' => 'XII IPS 1',
                'jenis_pelanggaran' => 'Minuman Keras',
                'tanggal' => '2026-01-15',
                'keterangan' => 'Kedapatan bersama 2 teman membawa minuman keras ke sekolah. Orang tua dipanggil dan diberikan pembinaan khusus.',
                'poin' => 10,
                'sanksi' => 'Skorsing',
            ],
        ];

        foreach ($catatanList as $c) {
            CatatanPelanggaran::create($c);
        }
        echo "  ✓ " . count($catatanList) . " data catatan pelanggaran\n";

        // ========== 6. UPDATE TOTAL POIN SISWA ==========
        // Hitung ulang total poin setiap siswa berdasarkan data pelanggaran
        $siswas = Siswa::all();
        foreach ($siswas as $siswa) {
            $totalPoin = Pelanggaran::where('nama_siswa', $siswa->nama_siswa)->sum('poin');
            $siswa->update(['total_poin' => $totalPoin]);
        }
        echo "  ✓ Total poin siswa berhasil diupdate\n";
    }
}
