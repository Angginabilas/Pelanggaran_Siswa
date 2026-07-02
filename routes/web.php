<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CatatanPelanggaranController;

// Halaman awal diarahkan ke login
Route::get('/', function () {
    return redirect()->route('Auth.login');
});

// LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('Auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('Auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// LUPA PASSWORD
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// HALAMAN SETELAH LOGIN
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // SISWA
    Route::get('/siswa', [SiswaController::class, 'index'])->name('Siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('Siswa.store');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('Siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('Siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('Siswa.destroy');

    // PELANGGARAN
    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('Pelanggaran.index');
    Route::get('/pelanggaran/create', [PelanggaranController::class, 'create'])->name('pelanggaran.create');
    Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::get('/pelanggaran/{id}/edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
    Route::put('/pelanggaran/{id}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
    Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');

    // CATATAN PELANGGARAN
    Route::get('/catatanpelanggaran', [CatatanPelanggaranController::class, 'index'])
        ->name('CatatanPelanggaran.index');

    Route::get('/catatanpelanggaran/create', [CatatanPelanggaranController::class, 'create'])
        ->name('CatatanPelanggaran.create');

    Route::post('/catatanpelanggaran', [CatatanPelanggaranController::class, 'store'])
        ->name('CatatanPelanggaran.store');

    Route::get('/catatanpelanggaran/{id}/edit', [CatatanPelanggaranController::class, 'edit'])
        ->name('CatatanPelanggaran.edit');

    Route::put('/catatanpelanggaran/{id}', [CatatanPelanggaranController::class, 'update'])
        ->name('CatatanPelanggaran.update');

    Route::delete('/catatanpelanggaran/{id}', [CatatanPelanggaranController::class, 'destroy'])
        ->name('CatatanPelanggaran.destroy');

});