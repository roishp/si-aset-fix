<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gedung;

class GedungSeeder extends Seeder
{
    /**
     * Seed 31 Gedung Induk UGM (Fasilitas Utama, Fakultas, dan Sekolah)
     */
    public function run(): void
    {
        $indukLists = [
            // === FAKULTAS ===
            [
                'kode_aset' => 'ASET-012',
                'nama' => 'Fakultas Teknik UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Salah satu fakultas teknik terbesar dan terbaik di Indonesia, berdiri sejak 1949.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-013',
                'nama' => 'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan (FK-KMK) UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Fakultas kedokteran tertua di Indonesia, berdiri sejak 1946, berlokasi di Sekip.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-014',
                'nama' => 'Fakultas Ekonomika dan Bisnis (FEB) UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Berdiri sejak 1955, salah satu sekolah bisnis terkemuka di Asia Tenggara.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-015',
                'nama' => 'Fakultas Hukum UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Salah satu fakultas hukum tertua and terbaik di Indonesia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-016',
                'nama' => 'Fakultas Ilmu Budaya (FIB) UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pusat kajian sastra, bahasa, arkeologi, sejarah, dan budaya Nusantara dan dunia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-017',
                'nama' => 'Fakultas MIPA UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pusat pengembangan ilmu sains dan matematika, berdiri sejak 1955.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-018',
                'nama' => 'Fakultas Psikologi UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Berdiri sejak 1965, salah satu program psikologi terkemuka di Indonesia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-019',
                'nama' => 'Fakultas Filsafat UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Satu-satunya fakultas filsafat negeri di Indonesia, fokus pada filsafat barat, timur, dan agama.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-020',
                'nama' => 'Fakultas Ilmu Sosial dan Politik (Fisipol) UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pusat kajian ilmu sosial, komunikasi, dan politik terkemuka di Indonesia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-021',
                'nama' => 'Fakultas Pertanian UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pusat pengembangan ilmu pertanian modern dan agribisnis di Indonesia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-022',
                'nama' => 'Fakultas Kehutanan UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pusat penelitian dan pendidikan kehutanan tropis terbaik di Indonesia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-023',
                'nama' => 'Fakultas Peternakan UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Menghasilkan ahli peternakan yang unggul dalam produksi dan teknologi ternak.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-024',
                'nama' => 'Fakultas Farmasi UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Mengkaji ilmu kefarmasian, obat-obatan tradisional, dan bahan alam Indonesia.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-025',
                'nama' => 'Fakultas Geografi UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pusat kajian ilmu kebumian, kartografi, penginderaan jauh, dan pembangunan wilayah.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-026',
                'nama' => 'Fakultas Biologi UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Fakultas biologi tertua di Indonesia, berdiri sejak 1955.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-027',
                'nama' => 'Fakultas Kedokteran Gigi UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Mengajarkan aspek konservasi gigi, orthodonti, dan endodontik secara komprehensif.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-028',
                'nama' => 'Fakultas Kedokteran Hewan UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Berdiri sejak 1946 sebagai Sekolah Tinggi Kedokteran Hewan, kini bagian UGM.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-029',
                'nama' => 'Fakultas Teknologi Pertanian (FTP) UGM',
                'kategori' => 'Fakultas',
                'deskripsi' => 'Pertama di Indonesia yang mengembangkan studi teknologi pangan dan hasil pertanian.',
                'foto' => 'placeholder.jpg'
            ],
            [
                'kode_aset' => 'ASET-030',
                'nama' => 'Sekolah Vokasi UGM',
                'kategori' => 'Sekolah',
                'deskripsi' => 'Pendidikan vokasi UGM yang berfokus pada keterampilan praktis dan terapan.',
                'foto' => 'placeholder.jpg'
            ]
        ];

        foreach ($indukLists as $induk) {
            $data = array_merge($induk, [
                'lokasi' => 'Universitas Gadjah Mada, Sleman, Yogyakarta',
                'kondisi' => 'Kondisi Baik',
                'parent_id' => null
            ]);
            
            Gedung::updateOrCreate(
                ['nama' => $induk['nama']], // Update by nama instead of kode_aset for reliability
                $data
            );
        }
    }
}
