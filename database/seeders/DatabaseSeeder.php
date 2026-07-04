<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\CatatanPelanggaran;
use App\Models\Sanksi;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(DummyDataSeeder::class);
    }
}
