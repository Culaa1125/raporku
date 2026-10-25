<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, AdminController, GuruController, SiswaController};

// ─── Auth ──────────────────────────────────────────────────────
Route::get('/',      [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin ─────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard',          [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Data Siswa
    Route::get('/siswa',              [AdminController::class, 'dataSiswa'])->name('admin.siswa');
    Route::get('/siswa/tambah',       [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::post('/siswa/tambah',      [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/siswa/{id}/edit',    [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/siswa/{id}',         [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}',      [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');

    // Data Guru
    Route::get('/guru',               [AdminController::class, 'dataGuru'])->name('admin.guru');
    Route::get('/guru/tambah',        [AdminController::class, 'createGuru'])->name('admin.guru.create');
    Route::post('/guru/tambah',       [AdminController::class, 'storeGuru'])->name('admin.guru.store');
    Route::get('/guru/{id}/edit',     [AdminController::class, 'editGuru'])->name('admin.guru.edit');
    Route::put('/guru/{id}',          [AdminController::class, 'updateGuru'])->name('admin.guru.update');
    Route::delete('/guru/{id}',       [AdminController::class, 'destroyGuru'])->name('admin.guru.destroy');

    // E-Rapor & Nilai
    Route::get('/erapor',             [AdminController::class, 'eRapor'])->name('admin.erapor');
    Route::post('/erapor/nilai',      [AdminController::class, 'storeNilai'])->name('admin.nilai.store');
    Route::get('/api/siswa-by-kelas', [AdminController::class, 'siswaByKelas'])->name('admin.api.siswa-by-kelas');

    // Rekap Nilai
    Route::get('/rekap-nilai',        [AdminController::class, 'rekapNilai'])->name('admin.rekap');

    // Mata Pelajaran
    Route::get('/mata-pelajaran',     [AdminController::class, 'dataMapel'])->name('admin.mapel');
    Route::post('/mata-pelajaran',    [AdminController::class, 'storeMapel'])->name('admin.mapel.store');
    Route::delete('/mata-pelajaran/{id}', [AdminController::class, 'destroyMapel'])->name('admin.mapel.destroy');
});

// ─── Guru ──────────────────────────────────────────────────────
Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard',      [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/erapor',         [GuruController::class, 'eRapor'])->name('guru.erapor');
    Route::post('/erapor/nilai',  [GuruController::class, 'storeNilai'])->name('guru.nilai.store');
    Route::get('/rekap-nilai',    [GuruController::class, 'rekapNilai'])->name('guru.rekap');
    Route::get('/api/siswa-by-kelas', [GuruController::class, 'siswaByKelas'])->name('guru.api.siswa-by-kelas');
});

// ─── Siswa ─────────────────────────────────────────────────────
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard',       [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/nilai',           [SiswaController::class, 'nilai'])->name('siswa.nilai');
    Route::get('/status-kelulusan',[SiswaController::class, 'statusKelulusan'])->name('siswa.kelulusan');
});