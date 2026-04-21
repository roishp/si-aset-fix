<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use App\Models\SaranAset;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin = \App\Models\Admin::find(session('admin_id'));

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Sesi tidak valid.');
        }

        $query = LaporanKerusakan::query();
        $querySaran = SaranAset::query();

        if ($admin->role !== 'admin_utama') {
            $query->where('gedung_id', $admin->gedung_id);
            $querySaran->where('gedung_id', $admin->gedung_id);
        }

        // 1. Statistik Utama Laporan
        $totalLaporan = (clone $query)->count();

        // 2. Rekap per Kategori
        $rekapKategori = (clone $query)->select(
            'kategori',
            \Illuminate\Support\Facades\DB::raw('count(*) as total'),
            \Illuminate\Support\Facades\DB::raw('sum(kondisi="Sangat Baik") as sangat_baik'),
            \Illuminate\Support\Facades\DB::raw('sum(kondisi="Baik") as baik'),
            \Illuminate\Support\Facades\DB::raw('sum(kondisi="Cukup") as cukup'),
            \Illuminate\Support\Facades\DB::raw('sum(kondisi="Rusak Ringan") as ringan'),
            \Illuminate\Support\Facades\DB::raw('sum(kondisi="Rusak Berat") as berat')
        )->groupBy('kategori')->orderByDesc('total')->get();

        // 3. Rekap per Gedung
        $rekapGedung = (clone $query)->with('gedung')
            ->select('gedung_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('gedung_id')
            ->orderByDesc('total')
            ->get();

        // 4. Rekap Ruangan Kritis (Sering dilaporkan)
        $ruanganKritis = (clone $query)->with('gedung')
            ->select('gedung_id', 'ruangan', 'sub_item', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('gedung_id', 'ruangan', 'sub_item')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 5. Statistik Saran Aset
        $totalSaran = (clone $querySaran)->count();

        // 6. Kategori barang yang diusulkan
        $kategoriSaran = (clone $querySaran)
            ->select('nama_aset', \Illuminate\Support\Facades\DB::raw('sum(jumlah) as total_jumlah'), \Illuminate\Support\Facades\DB::raw('count(*) as total_request'))
            ->groupBy('nama_aset')
            ->orderByDesc('total_request')
            ->limit(5)
            ->get();

        // 7. Total lokasi saran aset baru fakultas (Rekap per Gedung untuk Saran)
        $rekapGedungSaran = (clone $querySaran)->with('gedung')
            ->select('gedung_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('gedung_id')
            ->orderByDesc('total')
            ->get();

        // 8. Rincian lokasi tersering laporan saran aset baru
        $ruanganKritisSaran = (clone $querySaran)->with('gedung')
            ->select('gedung_id', 'ruangan', 'nama_aset', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('gedung_id', 'ruangan', 'nama_aset')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalLaporan', 'rekapKategori', 'rekapGedung', 'ruanganKritis', 'admin',
            'totalSaran', 'kategoriSaran', 'rekapGedungSaran', 'ruanganKritisSaran'
        ));
    }
    public function getData()
    {
        $admin = \App\Models\Admin::find(session('admin_id'));

        $query = LaporanKerusakan::query();
        $querySaran = SaranAset::query();

        if ($admin->role !== 'admin_utama') {
            $query->where('gedung_id', $admin->gedung_id);
            $querySaran->where('gedung_id', $admin->gedung_id);
        }

        return response()->json([
            'totalLaporan' => (clone $query)->count(),
            'totalSaran' => (clone $querySaran)->count(),
            'lastUpdate' => now()->format('H:i:s'),
        ]);
    }
}
