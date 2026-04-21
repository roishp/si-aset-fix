<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\Gedung;
use App\Models\LaporanKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LaporanKerusakanController extends Controller
{
    /**
     * Tampilkan form publik untuk membuat laporan.
     */
    public function create(Request $request)
    {
        // Harus dari link dengan ID gedung
        $gedung = Gedung::findOrFail($request->gedung_id);
        
        // Catatan: Model Gedung kita belum punya table ruangans resmi secara relasional Eloquent, 
        // sehingga properti $ruangan = $gedung->ruangan pada prompt pengguna mungkin kosong atau menyebabkan collection if table not exists.
        // Kita cukup lempar gedungnya.
        
        return view('laporan.create', compact('gedung'));
    }

    /**
     * Simpan laporan dari publik ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gedung_id' => 'required|exists:gedungs,id',
            'ruangan' => 'required|string|max:255',
            'lantai' => 'nullable|integer',
            'kategori' => 'required|string',
            'sub_item' => 'required|string|max:255',
            'kondisi' => 'required|in:Sangat Baik,Baik,Cukup,Rusak Ringan,Rusak Berat',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,heic,webp|max:10240', // max 10MB
            'nama_pelapor' => 'required|string|max:255',
            'nim_nip' => 'required|string|max:50',
            'fakultas' => 'required|string|max:255',
        ], [
            'foto.max' => '❌ Ukuran foto terlalu besar! Maksimal 10MB.',
            'foto.mimes' => '❌ Format foto tidak didukung! Gunakan JPG, PNG, HEIC, atau WEBP.',
            'foto.image' => '❌ File yang diupload bukan gambar!'
        ]);

        // Temporary Debug logs
        \Illuminate\Support\Facades\Log::info('Has file: ' . ($request->hasFile('foto') ? 'YES' : 'NO'));
        \Illuminate\Support\Facades\Log::info('All files: ' . json_encode($request->allFiles()));

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Sanitize filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            
            try {
                // Simpan ke Google Drive dengan akses publik agar link bisa dibuka di spreadsheet
                $path = Storage::disk('google')->putFileAs('laporan_kerusakan', $file, $filename, 'public');
                // Eksplisit set izin publik agar bisa dibuka siapa saja yang punya link
                Storage::disk('google')->setVisibility($path, 'public');
                $validated['foto'] = $path; 
                Log::info('Foto laporan berhasil disimpan di Google Drive (public): ' . $path);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan foto ke Google Drive: ' . $e->getMessage());
                $validated['foto'] = null;
            }
        } else {
            $validated['foto'] = null;
        }

        $laporan = LaporanKerusakan::create($validated);

        // Kirim ke Google Sheets via server (berjalan di localhost, mungkin diblokir di hosting)
        try {
            $googleSheets = app(\App\Services\GoogleSheetsService::class);
            $googleSheets->appendLaporan($laporan->load('gedung'));
            Log::info('Google Sheets: laporan #' . $laporan->id . ' berhasil dikirim');
        } catch (\Exception $e) {
            Log::error('Google Sheets error: ' . $e->getMessage());
        }

        // Bangun URL Google Drive dalam format viewer agar bisa dibuka di browser
        $fotoUrl = 'Tidak ada foto';
        if ($laporan->foto) {
            try {
                $adapter = Storage::disk('google')->getAdapter();
                $rawUrl = $adapter->getUrl($laporan->foto);
                // Konversi dari uc?id= ke format /file/d/view yang bisa dibuka di browser
                preg_match('/id=([^&]+)/', $rawUrl, $matches);
                $fileId = $matches[1] ?? null;
                $fotoUrl = $fileId
                    ? 'https://drive.google.com/file/d/' . $fileId . '/view'
                    : $rawUrl;
                Log::info('Google Drive viewer URL: ' . $fotoUrl);
            } catch (\Exception $e) {
                Log::warning('Gagal membuat URL GDrive: ' . $e->getMessage());
                $fotoUrl = 'https://drive.google.com/drive/folders/' . env('GOOGLE_DRIVE_FOLDER');
            }
        }

        $webhookRow = [
            $laporan->created_at->format('d/m/Y H:i'),
            $laporan->gedung->nama ?? '-',
            $laporan->ruangan,
            'Laporan',
            // Kolom Laporan
            $laporan->kategori,
            $laporan->sub_item,
            $laporan->kondisi,
            $laporan->deskripsi ?? '-',
            // Kolom Saran (kosong)
            '', '', '',
            // Data Pelapor
            $laporan->nama_pelapor,
            $laporan->nim_nip ?? '-',
            $laporan->fakultas ?? '-',
            $fotoUrl,
        ];

        // Dispatch event untuk update dashboard real-time via Pusher
        event(new DashboardUpdated());

        return redirect()->route('sukses')->with([
            'judul' => 'Laporan Kerusakan Terkirim!',
            'pesan' => 'Laporan kerusakan kamu sudah kami terima dan akan segera ditindaklanjuti. Terima kasih telah membantu menjaga fasilitas kampus UGM!',
            'webhook_type' => 'laporan',
            'webhook_data' => $webhookRow
        ]);
    }

    /**
     * Tampilkan daftar laporan untuk Admin.
     */
    public function index()
    {
        $laporans = LaporanKerusakan::with('gedung')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.laporan.index', compact('laporans'));
    }



    /**
     * Dashboard rekapitulasi data laporan untuk Admin.
     */
    public function dashboard()
    {
        // 1. Statistik Utama
        $totalLaporan = LaporanKerusakan::count();

        // 2. Rekap per Kategori
        $rekapKategori = LaporanKerusakan::select(
            'kategori',
            DB::raw('count(*) as total'),
            DB::raw('sum(kondisi="Sangat Baik") as sangat_baik'),
            DB::raw('sum(kondisi="Baik") as baik'),
            DB::raw('sum(kondisi="Cukup") as cukup'),
            DB::raw('sum(kondisi="Rusak Ringan") as ringan'),
            DB::raw('sum(kondisi="Rusak Berat") as berat')
        )->groupBy('kategori')->orderByDesc('total')->get();

        // 3. Rekap per Gedung
        $rekapGedung = LaporanKerusakan::with('gedung')
            ->select('gedung_id', DB::raw('count(*) as total'))
            ->groupBy('gedung_id')
            ->orderByDesc('total')
            ->get();

        // 4. Rekap Ruangan Kritis (Sering dilaporkan)
        $ruanganKritis = LaporanKerusakan::with('gedung')
            ->select('gedung_id', 'ruangan', 'sub_item', DB::raw('count(*) as total'))
            ->groupBy('gedung_id', 'ruangan', 'sub_item')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalLaporan',
            'rekapKategori', 'rekapGedung', 'ruanganKritis'
        ));
    }

    /**
     * Export data laporan ke Excel dengan multi-sheet.
     */
    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanKerusakanExport, 'laporan_kerusakan_ugm.xlsx');
    }
}
