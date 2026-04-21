<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\Gedung;
use App\Models\SaranAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaranAsetController extends Controller
{
    /**
     * Tampilkan form publik untuk saran aset baru.
     */
    public function create(Request $request)
    {
        $gedung = Gedung::findOrFail($request->gedung_id);
        return view('saran.create', compact('gedung'));
    }

    /**
     * Simpan saran aset baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gedung_id' => 'required|exists:gedungs,id',
            'ruangan' => 'required|string|max:255',
            'nama_aset' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,heic,webp|max:10240',
            'nama_pengusul' => 'required|string|max:255',
            'nim_nip' => 'required|string|max:50',
            'fakultas' => 'required|string|max:255',
        ], [
            'foto.max' => '❌ Ukuran foto terlalu besar! Maksimal 10MB.',
            'foto.mimes' => '❌ Format foto tidak didukung! Gunakan JPG, PNG, HEIC, atau WEBP.',
            'foto.image' => '❌ File yang diupload bukan gambar!'
        ]);

        // Temporary Debug logs
        \Illuminate\Support\Facades\Log::info('Has file (Saran): ' . ($request->hasFile('foto') ? 'YES' : 'NO'));
        \Illuminate\Support\Facades\Log::info('All files (Saran): ' . json_encode($request->allFiles()));

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Sanitize filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            
            try {
                // Simpan ke Google Drive dengan akses publik
                $path = \Illuminate\Support\Facades\Storage::disk('google')->putFileAs('saran_aset', $file, $filename, 'public');
                // Eksplisit set izin publik agar bisa dibuka siapa saja yang punya link
                \Illuminate\Support\Facades\Storage::disk('google')->setVisibility($path, 'public');
                $validated['foto'] = $path; // Menyimpan ID/path dari Google Drive
                Log::info('Foto saran berhasil disimpan di Google Drive (public): ' . $path);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan foto ke Google Drive: ' . $e->getMessage());
                $validated['foto'] = null;
            }
        } else {
            $validated['foto'] = null;
        }

        $saran = SaranAset::create($validated);

        // Kirim ke Google Sheets via server (berjalan di localhost, mungkin diblokir di hosting)
        try {
            $googleSheets = app(\App\Services\GoogleSheetsService::class);
            $googleSheets->appendSaran($saran->load('gedung'));
            Log::info('Google Sheets: saran #' . $saran->id . ' berhasil dikirim');
        } catch (\Exception $e) {
            Log::error('Google Sheets error: ' . $e->getMessage());
        }

        // Siapkan data untuk webhook Google Apps Script (fallback via browser)
        $fotoUrl = $saran->foto
            ? \Illuminate\Support\Facades\Storage::disk('google')->url($saran->foto)
            : 'Tidak ada foto';

        $webhookRow = [
            $saran->created_at->format('d/m/Y H:i'),
            $saran->gedung->nama ?? '-',
            $saran->ruangan,
            'Saran',
            // Kolom Laporan (kosong)
            '', '', '', '',
            // Kolom Saran
            $saran->nama_aset,
            (string)$saran->jumlah,
            $saran->alasan,
            // Data Pengusul
            $saran->nama_pengusul,
            $saran->nim_nip ?? '-',
            $saran->fakultas ?? '-',
            $fotoUrl,
        ];

        // Dispatch event untuk update dashboard real-time via Pusher
        event(new DashboardUpdated());

        return redirect()->route('sukses')->with([
            'judul' => 'Saran Aset Terkirim!',
            'pesan' => 'Saran penambahan aset kamu sudah kami terima dan akan dipertimbangkan. Terima kasih!',
            'webhook_type' => 'saran',
            'webhook_data' => $webhookRow
        ]);
    }

    /**
     * Admin: Daftar semua saran aset.
     */
    public function index()
    {
        $saranAsets = SaranAset::with('gedung')->latest()->paginate(20);
        return view('admin.saran-aset.index', compact('saranAsets'));
    }


}