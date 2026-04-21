<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleSheetsService;

class SyncToGoogleSheets extends Command
{
    protected $signature = 'sheets:sync';
    protected $description = 'Sync semua data laporan kerusakan & saran aset ke Google Sheets';

    public function handle(GoogleSheetsService $service): int
    {
        $this->info('🔄 Memulai sinkronisasi ke Google Sheets...');
        $this->newLine();

        // 1. Sync Laporan Kerusakan
        $this->info('📋 Sinkronisasi Laporan Kerusakan...');
        $countLaporan = $service->syncAllLaporan();
        $this->info("   ✅ {$countLaporan} laporan berhasil disinkronkan.");
        $this->newLine();

        // 2. Sync Saran Aset
        $this->info('➕ Sinkronisasi Saran Aset...');
        $countSaran = $service->syncAllSaran();
        $this->info("   ✅ {$countSaran} saran berhasil disinkronkan.");
        $this->newLine();

        $this->info('🎉 Sinkronisasi selesai! Total: ' . ($countLaporan + $countSaran) . ' data.');

        return self::SUCCESS;
    }
}
