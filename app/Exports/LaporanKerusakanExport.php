<?php

namespace App\Exports;

use App\Models\LaporanKerusakan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanKerusakanExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];
        
        // Ambil semua kategori unik yang ada di laporan
        $kategoris = LaporanKerusakan::select('kategori')->distinct()->pluck('kategori');
        
        // Jika belum ada data sama sekali, buat sheet kosong default
        if ($kategoris->isEmpty()) {
            $sheets[] = new LaporanKerusakanPerKategoriSheet('Semua Kategori');
            return $sheets;
        }

        // Buat satu sheet untuk setiap kategori
        foreach ($kategoris as $kategori) {
            $sheets[] = new LaporanKerusakanPerKategoriSheet($kategori);
        }

        return $sheets;
    }
}
