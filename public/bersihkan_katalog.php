<?php
// Letakkan di folder public/bersihkan_katalog.php di hosting Anda, lalu buka di browser
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\GedungSeeder;
use Database\Seeders\SubGedungSeeder;

try {
    echo "<h2>Proses Pembersihan Katalog Dimulai...</h2>";

    // 1. Matikan batasan foreign key agar bisa truncate
    Schema::disableForeignKeyConstraints();

    // 2. Hubungkan ke Database dan hapus data
    echo "- Menghapus data Laporan Kerusakan...<br>";
    if (Schema::hasTable('laporan_kerusakans')) {
        DB::table('laporan_kerusakans')->truncate();
    }

    echo "- Menghapus data Saran Aset...<br>";
    if (Schema::hasTable('saran_aset')) {
        DB::table('saran_aset')->truncate();
    }
    
    if (Schema::hasTable('sarans')) {
        DB::table('sarans')->truncate();
    }

    echo "- Menghapus data Gedung & Sub-Gedung lama...<br>";
    if (Schema::hasTable('gedungs')) {
        DB::table('gedungs')->truncate();
    }

    // 3. Jalankan Pengisian Ulang (Seeding)
    echo "- Mengisi ulang Katalog (Fakultas & Sekolah Vokasi)...<br>";
    Artisan::call('db:seed', ['--class' => 'GedungSeeder', '--force' => true]);

    echo "- Mengisi ulang Departemen...<br>";
    Artisan::call('db:seed', ['--class' => 'SubGedungSeeder', '--force' => true]);

    // 4. Hidupkan kembali batasan foreign key
    Schema::enableForeignKeyConstraints();

    echo "<h3 style='color:green'>BERHASIL! Katalog sekarang hanya berisi Fakultas dan Sekolah Vokasi.</h3>";
    echo "<br><b style='color:red;'>PENTING: Segera hapus file bersihkan_katalog.php ini dari hosting setelah ini!</b>";
    echo "<br><br><a href='/katalog'>Lihat Katalog Sekarang</a>";

} catch (\Exception $e) {
    if (Schema::hasAnyTable(['laporan_kerusakans', 'saran_aset', 'gedungs'])) {
        Schema::enableForeignKeyConstraints();
    }
    echo "<h3 style='color:red'>Gagal membersihkan katalog!</h3>";
    echo "<b>Pesan Error:</b> " . $e->getMessage();
}
