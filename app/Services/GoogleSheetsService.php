<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Sheets as GoogleSheets;
use Google\Service\Sheets\ValueRange;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    protected ?GoogleSheets $service = null;
    protected string $spreadsheetId;
    protected string $sheetName;

    // =========================================================================
    //  FORMAT UNIFIED (1 sheet, 1 tabel):
    //
    //  A=Tanggal | B=Gedung | C=Ruangan | D=Tipe
    //  --- LAPORAN KERUSAKAN ---
    //  E=Kategori | F=Item Rusak | G=Kondisi | H=Deskripsi
    //  --- SARAN ASET ---
    //  I=Nama Aset | J=Jumlah | K=Alasan
    //  --- DATA PELAPOR/PENGUSUL ---
    //  L=Nama | M=NIM/NIP | N=Fakultas | O=Foto
    // =========================================================================

    public function __construct()
    {
        $this->spreadsheetId = config('google.spreadsheet_id');
        $this->sheetName = trim(config('google.sheet_name', 'Sheet1'));

        try {
            $credentialsPath = config('google.service.file');

            if (!file_exists($credentialsPath)) {
                Log::warning('GoogleSheets: Credentials file not found at ' . $credentialsPath);
                return;
            }

            $client = new GoogleClient();
            $client->setScopes([GoogleSheets::SPREADSHEETS]);
            $client->setAuthConfig($credentialsPath);
            $client->setAccessType('offline');
            
            $guzzleClient = new Client([
                'timeout' => 3.0,
                'connect_timeout' => 2.0
            ]);
            $client->setHttpClient($guzzleClient);

            $this->service = new GoogleSheets($client);
        } catch (\Exception $e) {
            Log::error('GoogleSheets: Constructor initialization failed — ' . $e->getMessage());
        }
    }

    protected function getService(): ?GoogleSheets
    {
        if ($this->service) {
            return $this->service;
        }

        try {
            $credentialsPath = config('google.service.file');

            if (!file_exists($credentialsPath)) {
                Log::warning('GoogleSheets: Credentials file not found at ' . $credentialsPath);
                return null;
            }

            if (empty($this->spreadsheetId)) {
                Log::warning('GoogleSheets: GOOGLE_SPREADSHEET_ID is not set.');
                return null;
            }

            $client = new GoogleClient();
            $client->setScopes([GoogleSheets::SPREADSHEETS]);
            $client->setAuthConfig($credentialsPath);
            $client->setAccessType('offline');

            $guzzleClient = new Client([
                'timeout' => 3.0,
                'connect_timeout' => 2.0
            ]);
            $client->setHttpClient($guzzleClient);

            $this->service = new GoogleSheets($client);
            return $this->service;
        } catch (\Exception $e) {
            Log::error('GoogleSheets: Failed to initialize — ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Konversi URL Google Drive dari format uc?id= ke format file/d/view
     * agar bisa dibuka di browser sebagai viewer (bukan direct download).
     */
    protected function buildViewableUrl(string $rawUrl): string
    {
        preg_match('/id=([^&]+)/', $rawUrl, $matches);
        $fileId = $matches[1] ?? null;
        if ($fileId) {
            return 'https://drive.google.com/file/d/' . $fileId . '/view';
        }
        return $rawUrl; // fallback ke URL asli jika tidak bisa di-parse
    }

    protected function fotoUrl(?string $foto): string
    {
        if (!$foto) {
            return 'Tidak ada foto';
        }
        
        try {
            $adapter = \Illuminate\Support\Facades\Storage::disk('google')->getAdapter();
            $rawUrl = $adapter->getUrl($foto);
            return $this->buildViewableUrl($rawUrl);
        } catch (\Exception $e) {
            Log::warning('GoogleSheets: gagal ambil URL GDrive — ' . $e->getMessage());
            $folderId = env('GOOGLE_DRIVE_FOLDER');
            if ($folderId) {
                return 'https://drive.google.com/drive/folders/' . $folderId;
            }
            return 'Tidak ada foto';
        }
    }

    protected function fotoHyperlink(?string $foto): string
    {
        if (!$foto) {
            return 'Tidak ada foto';
        }
        $url = $this->fotoUrl($foto);
        return '=HYPERLINK("' . $url . '","Lihat Foto")';
    }

    protected function quoteSheetName(string $sheetName): string
    {
        if (str_contains($sheetName, ' ')) {
            return "'" . str_replace("'", "''", $sheetName) . "'";
        }
        return $sheetName;
    }

    protected function appendRow(array $row): bool
    {
        try {
            $service = $this->getService();
            if (!$service) return false;

            $range = $this->quoteSheetName($this->sheetName) . '!A:O';
            $body = new ValueRange();
            $body->setMajorDimension('ROWS');
            $body->setValues([$row]);

            $service->spreadsheets_values->append(
                $this->spreadsheetId,
                $range,
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            return true;
        } catch (\Exception $e) {
            Log::error("GoogleSheets: Failed to append row — " . $e->getMessage());
            return false;
        }
    }

    protected function appendRows(array $rows): bool
    {
        try {
            $service = $this->getService();
            if (!$service) return false;

            $range = $this->quoteSheetName($this->sheetName) . '!A:O';
            $body = new ValueRange();
            $body->setMajorDimension('ROWS');
            $body->setValues($rows);

            $service->spreadsheets_values->append(
                $this->spreadsheetId,
                $range,
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            return true;
        } catch (\Exception $e) {
            Log::error("GoogleSheets: Failed to bulk append — " . $e->getMessage());
            return false;
        }
    }

    protected function clearSheet(): bool
    {
        try {
            $service = $this->getService();
            if (!$service) return false;

            $range = $this->quoteSheetName($this->sheetName) . '!A2:O';
            $service->spreadsheets_values->clear(
                $this->spreadsheetId,
                $range,
                new \Google\Service\Sheets\ClearValuesRequest()
            );

            return true;
        } catch (\Exception $e) {
            Log::error("GoogleSheets: Failed to clear sheet — " . $e->getMessage());
            return false;
        }
    }

    // =========================================================================
    //  LAPORAN KERUSAKAN
    //  Kolom E-H diisi, kolom I-K dikosongkan
    // =========================================================================

    protected function buildLaporanRow($laporan): array
    {
        return [
            (string)$laporan->created_at->format('d/m/Y H:i'),   // A: Tanggal
            (string)($laporan->gedung->nama ?? '-'),              // B: Gedung
            (string)$laporan->ruangan,                            // C: Ruangan
            'Laporan',                                            // D: Tipe
            // --- Kolom Laporan (diisi) ---
            (string)$laporan->kategori,                           // E: Kategori
            (string)$laporan->sub_item,                           // F: Item Rusak
            (string)$laporan->kondisi,                            // G: Kondisi
            (string)($laporan->deskripsi ?? '-'),                 // H: Deskripsi
            // --- Kolom Saran (dikosongkan) ---
            '',                                                   // I: Nama Aset
            '',                                                   // J: Jumlah
            '',                                                   // K: Alasan
            // --- Data Pelapor ---
            (string)$laporan->nama_pelapor,                       // L: Nama
            (string)($laporan->nim_nip ?? '-'),                   // M: NIM/NIP
            (string)($laporan->fakultas ?? '-'),                  // N: Fakultas
            $this->fotoHyperlink($laporan->foto),                 // O: Foto
        ];
    }

    public function appendLaporan($laporan): bool
    {
        try {
            $row = $this->buildLaporanRow($laporan);
            Log::info('GoogleSheets appendLaporan #' . $laporan->id . ': ' . json_encode($row));
            return $this->appendRow($row);
        } catch (\Exception $e) {
            Log::error("GoogleSheets: appendLaporan #{$laporan->id} failed — " . $e->getMessage());
            return false;
        }
    }

    // =========================================================================
    //  SARAN ASET
    //  Kolom I-K diisi, kolom E-H dikosongkan
    // =========================================================================

    protected function buildSaranRow($saran): array
    {
        return [
            (string)$saran->created_at->format('d/m/Y H:i'),     // A: Tanggal
            (string)($saran->gedung->nama ?? '-'),                // B: Gedung
            (string)$saran->ruangan,                              // C: Ruangan
            'Saran',                                              // D: Tipe
            // --- Kolom Laporan (dikosongkan) ---
            '',                                                   // E: Kategori
            '',                                                   // F: Item Rusak
            '',                                                   // G: Kondisi
            '',                                                   // H: Deskripsi
            // --- Kolom Saran (diisi) ---
            (string)$saran->nama_aset,                            // I: Nama Aset
            (string)$saran->jumlah,                               // J: Jumlah
            (string)$saran->alasan,                               // K: Alasan
            // --- Data Pengusul ---
            (string)$saran->nama_pengusul,                        // L: Nama
            (string)($saran->nim_nip ?? '-'),                     // M: NIM/NIP
            (string)($saran->fakultas ?? '-'),                    // N: Fakultas
            $this->fotoHyperlink($saran->foto),                   // O: Foto
        ];
    }

    public function appendSaran($saran): bool
    {
        try {
            $row = $this->buildSaranRow($saran);
            Log::info('GoogleSheets appendSaran #' . $saran->id . ': ' . json_encode($row));
            return $this->appendRow($row);
        } catch (\Exception $e) {
            Log::error("GoogleSheets: appendSaran #{$saran->id} failed — " . $e->getMessage());
            return false;
        }
    }

    // =========================================================================
    //  SYNC ALL
    // =========================================================================

    public function syncAllLaporan(): int
    {
        return $this->syncAll();
    }

    public function syncAllSaran(): int
    {
        return $this->syncAll();
    }

    public function syncAll(): int
    {
        $laporans = \App\Models\LaporanKerusakan::with('gedung')->orderBy('created_at')->get();
        $sarans = \App\Models\SaranAset::with('gedung')->orderBy('created_at')->get();

        if ($laporans->isEmpty() && $sarans->isEmpty()) return 0;

        $this->clearSheet();

        $rows = [];
        foreach ($laporans as $l) {
            $rows[] = $this->buildLaporanRow($l);
        }
        foreach ($sarans as $s) {
            $rows[] = $this->buildSaranRow($s);
        }

        // Sort by tanggal (kolom pertama)
        usort($rows, fn($a, $b) => strcmp($a[0], $b[0]));

        $this->appendRows($rows);

        return count($rows);
    }

    /** @deprecated Status column removed */
    public function updateStatusLaporan($laporan): bool { return true; }

    /** @deprecated Status column removed */
    public function updateStatusSaran($saran): bool { return true; }
}
