<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaranAset;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Log;

class SaranAsetSeeder extends Seeder
{
    public function run(): void
    {
        $sarans = [
            [
                'gedung_id' => 12, // Fakultas Teknik UGM
                'ruangan' => 'Lab Informatika',
                'nama_aset' => 'Monitor 24 inch',
                'jumlah' => 10,
                'alasan' => 'Monitor lama sudah banyak yang dead pixel dan resolusi rendah, menghambat praktikum pemrograman visual dan desain CAD.',
                'foto' => null,
                'nama_pengusul' => 'Galih Wicaksono',
                'nim_nip' => '21/480123/TK/52915',
                'fakultas' => 'Fakultas Teknik',
                                'created_at' => '2025-01-10 09:00:00',
            ],
            [
                'gedung_id' => 17, // Fakultas MIPA UGM
                'ruangan' => 'R. Kuliah 301',
                'nama_aset' => 'AC Standing Floor 2PK',
                'jumlah' => 2,
                'alasan' => 'Ruangan sangat panas saat siang hari karena AC lama sudah tidak dingin, mahasiswa sulit konsentrasi saat kuliah.',
                'foto' => null,
                'nama_pengusul' => 'Dr. Sri Mulyani',
                'nim_nip' => '198003212006042001',
                'fakultas' => 'Fakultas MIPA',
                                'created_at' => '2025-01-18 11:30:00',
            ],
            [
                'gedung_id' => 27, // Fakultas Kedokteran Gigi UGM
                'ruangan' => 'Klinik Praktik',
                'nama_aset' => 'Dental Chair Unit',
                'jumlah' => 5,
                'alasan' => 'Unit dental chair yang ada sudah berumur 15 tahun dan sering error saat praktik klinik, menghambat jadwal praktik mahasiswa.',
                'foto' => null,
                'nama_pengusul' => 'Farah Nabila',
                'nim_nip' => '22/505678/KG/17823',
                'fakultas' => 'Fakultas Kedokteran Gigi',
                                'created_at' => '2025-01-28 14:00:00',
            ],
            [
                'gedung_id' => 20, // Fisipol UGM
                'ruangan' => 'R. Diskusi B',
                'nama_aset' => 'Kursi Lipat',
                'jumlah' => 30,
                'alasan' => 'Ruang diskusi sering kekurangan kursi saat acara seminar dan diskusi publik yang dihadiri banyak peserta.',
                'foto' => null,
                'nama_pengusul' => 'Bayu Aditya',
                'nim_nip' => '23/517890/SP/42310',
                'fakultas' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
                                'created_at' => '2025-02-05 10:15:00',
            ],
            [
                'gedung_id' => 22, // Fakultas Kehutanan UGM
                'ruangan' => 'Lab GIS',
                'nama_aset' => 'Laptop Workstation',
                'jumlah' => 8,
                'alasan' => 'Software ArcGIS dan QGIS membutuhkan spesifikasi tinggi, laptop lama sering hang saat proses rendering peta spasial.',
                'foto' => null,
                'nama_pengusul' => 'Nadia Kusuma',
                'nim_nip' => '21/487654/KT/25678',
                'fakultas' => 'Fakultas Kehutanan',
                                'created_at' => '2025-02-14 08:30:00',
            ],
            [
                'gedung_id' => 19, // Fakultas Filsafat UGM
                'ruangan' => 'Perpustakaan',
                'nama_aset' => 'Rak Buku Besi 5 Tingkat',
                'jumlah' => 4,
                'alasan' => 'Koleksi buku terus bertambah tapi rak sudah penuh, banyak buku ditumpuk di lantai dan sulit diakses.',
                'foto' => null,
                'nama_pengusul' => 'Arief Budiman',
                'nim_nip' => '20/462345/FS/14567',
                'fakultas' => 'Fakultas Filsafat',
                                'created_at' => '2025-02-20 13:45:00',
            ],
            [
                'gedung_id' => 29, // FTP UGM
                'ruangan' => 'Lab Pangan',
                'nama_aset' => 'Freezer -20°C',
                'jumlah' => 2,
                'alasan' => 'Sampel penelitian membutuhkan penyimpanan suhu rendah, freezer yang ada sudah penuh dan suhu tidak stabil.',
                'foto' => null,
                'nama_pengusul' => 'Winda Sari',
                'nim_nip' => '22/498712/TP/30912',
                'fakultas' => 'Fakultas Teknologi Pertanian',
                                'created_at' => '2025-03-01 09:50:00',
            ],
            [
                'gedung_id' => 23, // Fakultas Peternakan UGM
                'ruangan' => 'R. Kuliah 102',
                'nama_aset' => 'Proyektor Full HD',
                'jumlah' => 3,
                'alasan' => 'Proyektor lama resolusi rendah, tulisan dan gambar presentasi tidak terlihat jelas dari bangku belakang.',
                'foto' => null,
                'nama_pengusul' => 'Hendra Wijaya',
                'nim_nip' => '21/485432/PT/28134',
                'fakultas' => 'Fakultas Peternakan',
                                'created_at' => '2025-03-08 11:20:00',
            ],
            [
                'gedung_id' => 31, // Sekolah Pascasarjana UGM
                'ruangan' => 'R. Seminar',
                'nama_aset' => 'Wireless Presenter',
                'jumlah' => 5,
                'alasan' => 'Mahasiswa S2/S3 sering presentasi tesis/disertasi tapi harus terus berdiri di depan laptop untuk ganti slide.',
                'foto' => null,
                'nama_pengusul' => 'Mega Puspita',
                'nim_nip' => '23/520198/SP/71234',
                'fakultas' => 'Sekolah Pascasarjana',
                                'created_at' => '2025-03-15 15:00:00',
            ],
            [
                'gedung_id' => 28, // Fakultas Kedokteran Hewan UGM
                'ruangan' => 'Lab Anatomi',
                'nama_aset' => 'Mikroskop Digital',
                'jumlah' => 6,
                'alasan' => 'Mikroskop optik sudah usang dan susah dikalibrasi, mikroskop digital lebih efisien untuk dokumentasi praktikum.',
                'foto' => null,
                'nama_pengusul' => 'drh. Agus Pratama',
                'nim_nip' => '197609181999031001',
                'fakultas' => 'Fakultas Kedokteran Hewan',
                                'created_at' => '2025-03-22 10:35:00',
            ],
        ];

        foreach ($sarans as $data) {
            $saran = SaranAset::create($data);
            $this->command->info("✅ Saran #{$saran->id} — {$data['nama_aset']} x{$data['jumlah']}");
        }

        // Kirim semua data ke Google Sheets
        try {
            $googleSheets = app(GoogleSheetsService::class);
            $synced = $googleSheets->syncAllSaran();
            $this->command->info("📊 Google Sheets: {$synced} saran berhasil disinkron.");
        } catch (\Exception $e) {
            $this->command->warn("⚠️ Google Sheets sync gagal: " . $e->getMessage());
            Log::error('Seeder Google Sheets sync error: ' . $e->getMessage());
        }

        $this->command->info("🎉 Selesai! 10 data saran aset berhasil di-seed.");
    }
}
