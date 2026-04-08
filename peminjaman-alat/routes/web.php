<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/',      [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users',       UserController::class);
    Route::resource('alat',        AlatController::class);
    Route::resource('kategori',    KategoriController::class);
    Route::resource('peminjaman',  PeminjamanController::class);
    Route::resource('pengembalian',PengembalianController::class)->only(['index', 'destroy']);
    Route::get('log',              [LogAktivitasController::class, 'index'])->name('log.index');
});

// Petugas routes
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('persetujuan',          [PeminjamanController::class, 'daftarPersetujuan'])->name('persetujuan');
    Route::post('peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])->name('setujui');
    Route::post('peminjaman/{peminjaman}/tolak',   [PeminjamanController::class, 'tolak'])->name('tolak');
    Route::get('pengembalian',         [PengembalianController::class, 'pantau'])->name('pengembalian');
    Route::get('laporan',              [LaporanController::class, 'index'])->name('laporan');
    Route::get('laporan/cetak',        [LaporanController::class, 'cetak'])->name('laporan.cetak');
});

// Peminjam routes
Route::prefix('peminjam')->name('peminjam.')->middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('alat',                         [AlatController::class, 'daftarAlat'])->name('alat');
    Route::get('ajukan',                       [PeminjamanController::class, 'ajukan'])->name('ajukan');
    Route::post('ajukan',                      [PeminjamanController::class, 'simpanAjuan'])->name('ajukan.store');
    Route::get('riwayat',                      [PeminjamanController::class, 'riwayat'])->name('riwayat');
    Route::get('kembali/{peminjaman}',         [PengembalianController::class, 'formKembali'])->name('kembali');
    Route::post('kembali/{peminjaman}',        [PengembalianController::class, 'prosesPengembalian'])->name('kembali.store');
});
