<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gedung;
use App\Models\LaporanKerusakan;
use App\Models\SaranAset;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedLaporan();
        $this->seedSaran();
    }

    private function seedLaporan()
    {
        $items = [
            ['nama' => 'Fakultas Teknik UGM', 'ruangan' => 'SGLC Lt. 3', 'item' => 'Lampu LED', 'kondisi' => 'Rusak Ringan'],
            ['nama' => 'Fakultas Teknik UGM', 'ruangan' => 'Departemen Teknik Sipil', 'item' => 'Papan Tulis', 'kondisi' => 'Cukup'],
            ['nama' => 'Fakultas MIPA UGM', 'ruangan' => 'Lab Fisika Dasar', 'item' => 'Stop Kontak', 'kondisi' => 'Rusak Berat'],
            ['nama' => 'Fakultas MIPA UGM', 'ruangan' => 'R. Sidang', 'item' => 'AC Split', 'kondisi' => 'Cukup'],
            ['nama' => 'Fakultas Ekonomika dan Bisnis (FEB) UGM', 'ruangan' => 'Auditorium', 'item' => 'Kursi Lipat', 'kondisi' => 'Rusak Berat'],
            ['nama' => 'Fakultas Psikologi UGM', 'ruangan' => 'R. Kelas A', 'item' => 'Proyektor', 'kondisi' => 'Rusak Ringan'],
            ['nama' => 'Fakultas Biologi UGM', 'ruangan' => 'Koleksi Spesimen', 'item' => 'Lemari Kaca', 'kondisi' => 'Cukup'],
            ['nama' => 'Sekolah Vokasi UGM', 'ruangan' => 'Lab Komputer Lt. 2', 'item' => 'Kabel LAN', 'kondisi' => 'Rusak Ringan'],
            ['nama' => 'Fakultas Kehutanan UGM', 'ruangan' => 'Lobby Utama', 'item' => 'Pintu Kacamata', 'kondisi' => 'Rusak Berat'],
            ['nama' => 'Fakultas Filsafat UGM', 'ruangan' => 'Kantantin', 'item' => 'Meja Makan', 'kondisi' => 'Cukup'],
        ];

        foreach ($items as $i) {
            $gedung = Gedung::where('nama', $i['nama'])->first();
            if ($gedung) {
                for ($j = 1; $j <= 2; $j++) {
                    LaporanKerusakan::create([
                        'gedung_id' => $gedung->id,
                        'ruangan' => $i['ruangan'],
                        'kategori' => 'Lainnya',
                        'sub_item' => $i['item'] . " #" . $j,
                        'kondisi' => $i['kondisi'],
                        'deskripsi' => 'Data testing untuk simulasi dashboard.',
                        'nama_pelapor' => 'User Tester ' . rand(1, 100),
                        'nim_nip' => rand(100000, 999999),
                        'fakultas' => $i['nama'],
                                                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }
    }

    private function seedSaran()
    {
        $items = [
            ['nama' => 'Fakultas Teknik UGM', 'item' => 'Webcam 4K'],
            ['nama' => 'Fakultas MIPA UGM', 'item' => 'Printer 3D'],
            ['nama' => 'Fakultas Psikologi UGM', 'item' => 'Kursi Ergonomis'],
            ['nama' => 'Sekolah Vokasi UGM', 'item' => 'Solder Digital'],
            ['nama' => 'Fakultas Biologi UGM', 'item' => 'Kulkas Lab'],
        ];

        foreach ($items as $i) {
            $gedung = Gedung::where('nama', $i['nama'])->first();
            if ($gedung) {
                for ($j = 1; $j <= 4; $j++) {
                    SaranAset::create([
                        'gedung_id' => $gedung->id,
                        'ruangan' => 'R. Umum',
                        'nama_aset' => $i['item'] . " #" . $j,
                        'jumlah' => rand(1, 10),
                        'alasan' => 'Dibutuhkan untuk penunjang kegiatan praktikum mahasiswa angkatan terbaru.',
                        'nama_pengusul' => 'Pengusul ke-' . rand(1, 50),
                        'nim_nip' => rand(100000, 999999),
                        'fakultas' => $i['nama'],
                        'created_at' => Carbon::now()->subDays(rand(1, 20)),
                    ]);
                }
            }
        }
    }
}
