<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaranController;
use App\Models\Gedung;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\LaporanKerusakanController;
use App\Http\Controllers\SaranAsetController;
use App\Http\Controllers\AdminProfilController;




use App\Models\LaporanKerusakan;
use App\Models\SaranAset;

// Halaman Beranda
Route::get('/', function () {
    $totalLaporan = LaporanKerusakan::count();
    $totalSaran = SaranAset::count();
    $totalSemua = $totalLaporan + $totalSaran;

    return view('beranda', compact('totalLaporan', 'totalSaran', 'totalSemua'));
})->name('beranda');

// Halaman Katalog (hanya gedung utama / tanpa parent)
Route::get('/katalog', [GedungController::class, 'index'])->name('katalog.index');

// Halaman detail gedung / daftar sub-gedung
Route::get('/katalog/{id}', [GedungController::class, 'show'])->name('gedung.show');

// Halaman Kontak (Hubungi Kami)
Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

// Halaman Sukses
Route::get('/sukses', function() {
    return view('sukses');
})->name('sukses');

// DEBUG: Cek permission folder upload (Hapus setelah dipakai)
Route::get('/cek-upload', function() {
    $path = public_path('uploads/laporan');
    return [
        'base_path' => base_path(),
        'public_path' => public_path(),
        'target_path' => $path,
        'exists' => is_dir($path),
        'writable' => is_writable($path),
        'files' => is_dir($path) ? scandir($path) : 'Folder tidak ada',
    ];
});

// Jalur untuk menyimpan saran ke database
Route::post('/kirim-saran', [SaranController::class, 'simpan']);

// ========= AUTH & ADMIN ROUTES ========= //

// Login routes (tanpa middleware)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

// Protected routes (Hanya yang sudah login admin)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function() {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
         ->name('dashboard');
    Route::get('/dashboard/data', [AdminDashboardController::class, 'getData'])
         ->name('dashboard.data');
    Route::get('/laporan', [LaporanKerusakanController::class, 'index'])
         ->name('laporan.index');
    Route::get('/laporan/export', [LaporanKerusakanController::class, 'export'])
         ->name('laporan.export');
    // Route::patch('/laporan/{id}/status', [LaporanKerusakanController::class, 'updateStatus'])
    //      ->name('laporan.status');
    // Kotak Saran
    Route::get('/saran', [SaranController::class, 'index'])
         ->name('saran.index');
    
    // Saran Penambahan Aset
    Route::get('/saran-aset', [SaranAsetController::class, 'index'])
         ->name('saran-aset.index');

    // Profil admin
    Route::get('/profil', [AdminProfilController::class, 'index'])
         ->name('profil');
    Route::patch('/profil/nama', [AdminProfilController::class, 'updateNama'])
         ->name('profil.nama');
    Route::patch('/profil/password', [AdminProfilController::class, 'updatePassword'])
         ->name('profil.password');

    // Kelola Admin / Management
    Route::get('/kelola-admin', [AdminManagementController::class, 'index'])
         ->name('management.index');
    Route::post('/kelola-admin', [AdminManagementController::class, 'store'])
         ->name('management.store');
    Route::delete('/kelola-admin/{id}', [AdminManagementController::class, 'destroy'])
         ->name('management.destroy');

    // Gedung index (opsional untuk admin utama)
    Route::get('/gedung', [GedungController::class, 'index'])
         ->name('gedung.index');
});

// ========= LAPORAN KERUSAKAN (PUBLIK) ========= //
Route::get('/laporan/buat', [LaporanKerusakanController::class, 'create'])->name('laporan.create');
Route::post('/laporan/buat', [LaporanKerusakanController::class, 'store'])->name('laporan.store');

// ========= SARAN ASET (PUBLIK) ========= //
Route::get('/saran/buat', [SaranAsetController::class, 'create'])->name('saran-aset.create');
Route::post('/saran/buat', [SaranAsetController::class, 'store'])->name('saran-aset.store');