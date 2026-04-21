<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanKerusakan;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Log;

class LaporanKerusakanSeeder extends Seeder
{
    public function run(): void
    {
        $laporans = [
            [
                'gedung_id' => 12, // Fakultas Teknik UGM
                'ruangan' => 'R.2.1',
                'lantai' => 2,
                'kategori' => 'Elektronik',
                'sub_item' => 'AC',
                'kondisi' => 'Rusak Sedang',
                'deskripsi' => 'AC tidak dingin, hanya keluar angin biasa. Sudah lebih dari 2 minggu.',
                'foto' => null,
                'nama_pelapor' => 'Andi Prasetyo',
                'nim_nip' => '21/479832/TK/52800',
                'fakultas' => 'Fakultas Teknik',
                                'created_at' => '2025-01-15 10:30:00',
            ],
            [
                'gedung_id' => 17, // Fakultas MIPA UGM
                'ruangan' => 'Lab Komputer Lt.3',
                'lantai' => 3,
                'kategori' => 'Elektronik',
                'sub_item' => 'Komputer',
                'kondisi' => 'Rusak Berat',
                'deskripsi' => 'Komputer no. 8 dan 12 tidak bisa menyala sama sekali, power supply mati total.',
                'foto' => null,
                'nama_pelapor' => 'Siti Nurhaliza',
                'nim_nip' => '22/498156/PA/20914',
                'fakultas' => 'Fakultas MIPA',
                                'created_at' => '2025-01-22 14:15:00',
            ],
            [
                'gedung_id' => 15, // Fakultas Hukum UGM
                'ruangan' => 'R. Sidang Utama',
                'lantai' => 1,
                'kategori' => 'Meja & Kursi',
                'sub_item' => 'Kursi Mahasiswa',
                'kondisi' => 'Rusak Ringan',
                'deskripsi' => 'Kursi baris ke-3 dari belakang goyang dan sandaran longgar, masih bisa diduduki tapi tidak nyaman.',
                'foto' => null,
                'nama_pelapor' => 'Budi Santoso',
                'nim_nip' => '20/456721/HK/18234',
                'fakultas' => 'Fakultas Hukum',
                                'created_at' => '2025-02-03 08:45:00',
            ],
            [
                'gedung_id' => 13, // FK-KMK UGM
                'ruangan' => 'Aula Lt.2',
                'lantai' => 2,
                'kategori' => 'Elektronik',
                'sub_item' => 'Proyektor',
                'kondisi' => 'Rusak Berat',
                'deskripsi' => 'Proyektor gambar berkedip-kedip dan warna kekuningan, sudah dicoba ganti kabel tapi tetap sama.',
                'foto' => null,
                'nama_pelapor' => 'Dr. Ratna Dewi',
                'nim_nip' => '197805152005012001',
                'fakultas' => 'Fakultas Kedokteran',
                                'created_at' => '2025-02-10 11:00:00',
            ],
            [
                'gedung_id' => 14, // FEB UGM
                'ruangan' => 'R.3.4',
                'lantai' => 3,
                'kategori' => 'Pintu & Jendela',
                'sub_item' => 'Engsel Pintu',
                'kondisi' => 'Rusak Sedang',
                'deskripsi' => 'Pintu ruang kelas sulit ditutup karena engsel atas sudah lepas sebelah, pintu miring.',
                'foto' => null,
                'nama_pelapor' => 'Rizky Firmansyah',
                'nim_nip' => '21/483920/EK/39201',
                'fakultas' => 'Fakultas Ekonomika dan Bisnis',
                                'created_at' => '2025-02-17 09:20:00',
            ],
            [
                'gedung_id' => 18, // Fakultas Psikologi UGM
                'ruangan' => 'R. Konseling A',
                'lantai' => 1,
                'kategori' => 'Instalasi Listrik',
                'sub_item' => 'Saklar Rusak',
                'kondisi' => 'Rusak Ringan',
                'deskripsi' => 'Saklar lampu kadang nyala kadang tidak, harus ditekan berkali-kali baru menyala.',
                'foto' => null,
                'nama_pelapor' => 'Anisa Rahmawati',
                'nim_nip' => '22/501432/PS/15782',
                'fakultas' => 'Fakultas Psikologi',
                                'created_at' => '2025-02-25 13:50:00',
            ],
            [
                'gedung_id' => 30, // Sekolah Vokasi UGM
                'ruangan' => 'Workshop Mesin',
                'lantai' => 1,
                'kategori' => 'Elektronik',
                'sub_item' => 'Kipas Angin',
                'kondisi' => 'Rusak Sedang',
                'deskripsi' => 'Kipas angin berdiri di pojok ruang bunyi berisik dan bergetar kencang saat kecepatan tinggi.',
                'foto' => null,
                'nama_pelapor' => 'Muhammad Faisal',
                'nim_nip' => '23/512876/SV/60123',
                'fakultas' => 'Sekolah Vokasi',
                                'created_at' => '2025-03-05 10:10:00',
            ],
            [
                'gedung_id' => 16, // FIB UGM
                'ruangan' => 'Perpustakaan Lt.1',
                'lantai' => 1,
                'kategori' => 'Meja & Kursi',
                'sub_item' => 'Meja Mahasiswa',
                'kondisi' => 'Rusak Ringan',
                'deskripsi' => 'Meja baca nomor 5 kaki depan kiri goyang, meja tidak stabil saat dipakai menulis.',
                'foto' => null,
                'nama_pelapor' => 'Putri Handayani',
                'nim_nip' => '20/467234/SA/19845',
                'fakultas' => 'Fakultas Ilmu Budaya',
                                'created_at' => '2025-03-12 15:30:00',
            ],
            [
                'gedung_id' => 21, // Fakultas Pertanian UGM
                'ruangan' => 'Lab Tanah',
                'lantai' => 1,
                'kategori' => 'Instalasi Air',
                'sub_item' => 'Keran Air',
                'kondisi' => 'Rusak Berat',
                'deskripsi' => 'Keran wastafel lab bocor deras, air terus mengalir meski sudah diputar kencang. Lantai jadi licin.',
                'foto' => null,
                'nama_pelapor' => 'Prof. Haryanto',
                'nim_nip' => '196712031993031002',
                'fakultas' => 'Fakultas Pertanian',
                                'created_at' => '2025-03-18 07:55:00',
            ],
            [
                'gedung_id' => 25, // Fakultas Geografi UGM
                'ruangan' => 'R.1.2',
                'lantai' => 1,
                'kategori' => 'Papan Tulis & Proyektor',
                'sub_item' => 'Layar Proyektor',
                'kondisi' => 'Rusak Sedang',
                'deskripsi' => 'Layar proyektor roll-up macet di tengah, tidak bisa ditarik turun penuh. Presentasi jadi terpotong.',
                'foto' => null,
                'nama_pelapor' => 'Dian Permata Sari',
                'nim_nip' => '21/490817/GE/22456',
                'fakultas' => 'Fakultas Geografi',
                                'created_at' => '2025-03-24 12:40:00',
            ],
        ];

        foreach ($laporans as $data) {
            $laporan = LaporanKerusakan::create($data);
            $this->command->info("✅ Laporan #{$laporan->id} — {$data['sub_item']} ({$data['kondisi']})");
        }

        // Kirim semua data ke Google Sheets
        try {
            $googleSheets = app(GoogleSheetsService::class);
            $synced = $googleSheets->syncAllLaporan();
            $this->command->info("📊 Google Sheets: {$synced} laporan berhasil disinkron.");
        } catch (\Exception $e) {
            $this->command->warn("⚠️ Google Sheets sync gagal: " . $e->getMessage());
            Log::error('Seeder Google Sheets sync error: ' . $e->getMessage());
        }

        $this->command->info("🎉 Selesai! 10 data laporan kerusakan berhasil di-seed.");
    }
}
