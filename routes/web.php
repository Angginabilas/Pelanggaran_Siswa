<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CatatanPelanggaranController;
use App\Http\Controllers\UserController;

// Halaman awal diarahkan ke login
Route::get('/', function () {
    return redirect()->route('Auth.login');
});

// LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('Auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('Auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// HALAMAN SETELAH LOGIN (read-only untuk semua role)
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // SISWA - read
    Route::get('/siswa', [SiswaController::class, 'index'])->name('Siswa.index');

    // PELANGGARAN - read
    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('Pelanggaran.index');

    // REDIRECT: Catatan Pelanggaran digabung ke Pelanggaran
    Route::get('/catatanpelanggaran', function () {
        return redirect()->route('Pelanggaran.index');
    });
    Route::get('/catatanpelanggaran/{any}', function () {
        return redirect()->route('Pelanggaran.index');
    })->where('any', '.*');

    // --- CRUD: HANYA UNTUK ADMIN ---
    Route::middleware('role:admin')->group(function () {

        // MANAJEMEN AKUN
        Route::get('/users', [UserController::class, 'index'])->name('User.index');
        Route::post('/users', [UserController::class, 'store'])->name('User.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('User.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('User.destroy');

        // SISWA
        Route::post('/siswa', [SiswaController::class, 'store'])->name('Siswa.store');
        Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('Siswa.edit');
        Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('Siswa.update');
        Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('Siswa.destroy');

        // PELANGGARAN
        Route::get('/pelanggaran/create', [PelanggaranController::class, 'create'])->name('Pelanggaran.create');
        Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('Pelanggaran.store');
        Route::get('/pelanggaran/{id}/edit', [PelanggaranController::class, 'edit'])->name('Pelanggaran.edit');
        Route::put('/pelanggaran/{id}', [PelanggaranController::class, 'update'])->name('Pelanggaran.update');
        Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('Pelanggaran.destroy');
    });

});
