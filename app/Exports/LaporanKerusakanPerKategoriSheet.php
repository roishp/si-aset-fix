<?php

namespace App\Exports;

use App\Models\LaporanKerusakan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKerusakanPerKategoriSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    private $kategori;

    public function __construct(string $kategori)
    {
        $this->kategori = $kategori;
    }

    public function query()
    {
        if ($this->kategori === 'Semua Kategori') {
            return LaporanKerusakan::query()->with('gedung');
        }
        
        return LaporanKerusakan::query()->with('gedung')->where('kategori', $this->kategori);
    }

    public function title(): string
    {
        // Excel worksheet limits title to 31 chars and invalid characters \ / ? * : [ ]
        $title = str_replace(['\\', '/', '?', '*', ':', '[', ']'], '', $this->kategori);
        return substr($title, 0, 31);
    }

    public function headings(): array
    {
        return [
            'ID Laporan',
            'Tanggal Dibuat',
            'Nama Gedung',
            'Ruangan',
            'Lantai',
            'Kategori',
            'Item Rusak',
            'Tingkat Kerusakan',
            'Deskripsi',
            'Nama Pelapor',
            'NIM/NIP',
            'Fakultas'
        ];
    }

    public function map($laporan): array
    {
        return [
            $laporan->id,
            $laporan->created_at->format('Y-m-d H:i:s'),
            $laporan->gedung->nama ?? '-',
            $laporan->ruangan,
            $laporan->lantai ?? '-',
            $laporan->kategori,
            $laporan->sub_item,
            $laporan->kondisi,
            $laporan->deskripsi ?? '-',
            $laporan->nama_pelapor,
            $laporan->nim_nip ?? '-',
            $laporan->fakultas ?? '-'
        ];
    }
}
