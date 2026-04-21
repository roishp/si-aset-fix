<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gedung;

class SubGedungSeeder extends Seeder
{
    /**
     * Seed data Sub-Gedung/Departemen ke Gedung Induk (Fakultas/Sekolah)
     */
    public function run(): void
    {
        // Peta parent_nama => daftar string child_nama
        $map = [
            'Fakultas Teknik UGM' => [
                'Gedung SGLC (Smart and Green Learning Center) - Gedung utama 11 lantai Fakultas Teknik',
                'Departemen Teknik Sipil dan Lingkungan',
                'Departemen Teknik Mesin dan Industri',
                'Departemen Teknik Elektro dan Teknologi Informasi',
                'Departemen Teknik Nuklir dan Teknik Fisika',
                'Departemen Teknik Kimia',
                'Departemen Teknik Geodesi',
                'Departemen Teknik Geologi',
                'Departemen Teknik Arsitektur dan Perencanaan'
            ],
            'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan (FK-KMK) UGM' => [
                'Gedung Radioputro',
                'Departemen Anatomi',
                'Departemen Fisiologi',
                'Departemen Ilmu Penyakit Dalam',
                'Departemen Ilmu Kesehatan Jiwa',
                'Departemen Ilmu Kesehatan Anak',
                'Departemen Ilmu Bedah',
                'Departemen Obstetri dan Ginekologi',
                'Departemen Kesehatan Masyarakat',
                'Departemen Keperawatan'
            ],
            'Fakultas Ekonomika dan Bisnis (FEB) UGM' => [
                'Gedung Pertamina Tower FEB',
                'Departemen Ilmu Ekonomi',
                'Departemen Manajemen',
                'Departemen Akuntansi'
            ],
            'Fakultas Hukum UGM' => [
                'Gedung Law Faculty UGM',
                'Departemen Hukum Perdata',
                'Departemen Hukum Pidana',
                'Departemen Hukum Internasional',
                'Departemen Hukum Tata Negara'
            ],
            'Fakultas Ilmu Budaya (FIB) UGM' => [
                'Gedung FIB UGM',
                'Departemen Arkeologi',
                'Departemen Sejarah',
                'Departemen Antropologi Budaya',
                'Departemen Bahasa dan Sastra Indonesia',
                'Departemen Sastra Inggris',
                'Departemen Sastra Arab',
                'Departemen Sastra Jawa',
                'Departemen Sastra Jepang',
                'Departemen Sastra Prancis',
                'Departemen Pariwisata',
                'Departemen Bahasa dan Kebudayaan Korea'
            ],
            'Fakultas MIPA UGM' => [
                'Gedung MIPA UGM',
                'Departemen Matematika',
                'Departemen Fisika',
                'Departemen Kimia',
                'Departemen Biologi',
                'Departemen Ilmu Komputer dan Elektronika'
            ],
            'Fakultas Psikologi UGM' => [
                'Gedung Psikologi UGM'
            ],
            'Fakultas Filsafat UGM' => [
                'Gedung Filsafat UGM'
            ],
            'Fakultas Ilmu Sosial dan Politik (Fisipol) UGM' => [
                'Gedung Fisipol UGM',
                'Departemen Politik dan Pemerintahan',
                'Departemen Sosiologi',
                'Departemen Komunikasi',
                'Departemen Hubungan Internasional',
                'Departemen Manajemen dan Kebijakan Publik',
                'Departemen Pembangunan Sosial dan Kesejahteraan'
            ],
            'Fakultas Pertanian UGM' => [
                'Gedung Pertanian UGM',
                'Departemen Agronomi dan Hortikultura',
                'Departemen Ilmu Tanah',
                'Departemen Perlindungan Tanaman',
                'Departemen Sosial Ekonomi Pertanian (Agribisnis)',
                'Departemen Perikanan'
            ],
            'Fakultas Kehutanan UGM' => [
                'Gedung Kehutanan UGM',
                'Departemen Manajemen Hutan',
                'Departemen Budidaya Hutan',
                'Departemen Teknologi Hasil Hutan',
                'Departemen Konservasi Sumberdaya Hutan'
            ],
            'Fakultas Peternakan UGM' => [
                'Gedung Peternakan UGM',
                'Kandang Fakultas Peternakan',
                'Departemen Nutrisi dan Makanan Ternak',
                'Departemen Produksi Ternak',
                'Departemen Teknologi Hasil Ternak'
            ],
            'Fakultas Farmasi UGM' => [
                'Gedung Farmasi UGM',
                'Departemen Farmakologi dan Farmasi Klinik',
                'Departemen Farmasetika',
                'Departemen Kimia Farmasi',
                'Departemen Biologi Farmasi'
            ],
            'Fakultas Geografi UGM' => [
                'Gedung Geografi UGM',
                'Departemen Geografi Lingkungan',
                'Departemen Kartografi dan Penginderaan Jauh',
                'Departemen Pembangunan Wilayah'
            ],
            'Fakultas Biologi UGM' => [
                'Gedung Biologi UGM',
                'Departemen Mikrobiologi',
                'Departemen Sistematika Tumbuhan',
                'Lab. Sistematika Hewan'
            ],
            'Fakultas Kedokteran Gigi UGM' => [
                'Gedung Kedokteran Gigi UGM'
            ],
            'Fakultas Kedokteran Hewan UGM' => [
                'Gedung Kedokteran Hewan UGM',
                'Rumah Sakit Hewan Prof. Soeparwi'
            ],
            'Fakultas Teknologi Pertanian (FTP) UGM' => [
                'Gedung Teknologi Pertanian UGM',
                'Departemen Teknologi Pangan dan Hasil Pertanian',
                'Departemen Teknik Pertanian dan Biosistem',
                'Departemen Teknologi Industri Pertanian'
            ],
            'Sekolah Vokasi UGM' => [
                'Departemen Teknik Mesin',
                'Departemen Teknik Sipil',
                'Departemen Teknik Elektro dan Informatika',
                'Departemen Teknik Kebumian',
                'Departemen Teknologi Hayati dan Veteriner',
                'Departemen Ekonomika dan Bisnis',
                'Departemen Layanan dan Informasi Kesehatan',
                'Departemen Bahasa, Seni, dan Manajemen Budaya'
            ],
            'Sekolah Pascasarjana UGM' => [
                'Gedung Pascasarjana Unit I',
                'Gedung Pascasarjana Unit II',
                'Gedung Pascasarjana Unit III',
                'Gedung PAU Pascasarjana'
            ]
        ];

        foreach ($map as $parentName => $childrenList) {
            $parent = Gedung::where('nama', $parentName)->first();

            if (!$parent) {
                if ($this->command) {
                    $this->command->warn("Parent '{$parentName}' tidak ditemukan, skip children-nya.");
                }
                continue;
            }

            $counter = 1;
            foreach ($childrenList as $childName) {
                // Generate a simple code like ASET-012-01
                $kodeStr = str_pad($counter, 2, '0', STR_PAD_LEFT);
                $childKodeAset = $parent->kode_aset . '-' . $kodeStr;

                Gedung::updateOrCreate(
                    ['nama' => $childName, 'parent_id' => $parent->id],
                    [
                        'kode_aset' => $childKodeAset,
                        'kategori'  => (str_starts_with($childName, 'Departemen')) ? 'Departemen' : 'Sub-Unit',
                        'deskripsi' => "Bagian dari {$parent->nama}",
                        'lokasi'    => "Lingkungan {$parent->nama}",
                        'kondisi'   => 'Kondisi Baik',
                        'foto'      => 'placeholder.jpg'
                    ]
                );
                
                $counter++;
            }
        }
    }
}
