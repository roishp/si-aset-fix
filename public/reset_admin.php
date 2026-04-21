<?php
// Letakkan di folder public/reset_admin.php di hosting Anda, lalu buka di browser
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;

try {
    // Hapus admin lama (jika ada) agar tidak duplikat
    Admin::where('email', 'adminSi-Aset@gmail.com')->delete();

    // Buat admin baru
    $admin = new Admin();
    $admin->nama = 'Admin Utama';
    $admin->email = 'adminSi-Aset@gmail.com';
    $admin->password = 'admin+62'; // Model Laravel 10+ dengan cast 'hashed' akan men-hash ini otomatis
    $admin->role = 'admin_utama';
    $admin->save();

    echo "<h2>Sukses! Akun Admin telah diperbarui.</h2>";
    echo "Silakan login ke Dashboard dengan:<br>";
    echo "<b>Email:</b> adminSi-Aset@gmail.com<br>";
    echo "<b>Password:</b> admin+62";
    echo "<br><br><b style='color:red;'>PENTING: Segera hapus file reset_admin.php ini dari hosting setelah Anda berhasil login!</b>";
} catch (\Exception $e) {
    echo "<h2>Gagal membuat admin!</h2>";
    echo "Error: " . $e->getMessage();
}
