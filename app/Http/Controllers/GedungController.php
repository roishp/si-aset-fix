<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = \App\Models\Gedung::whereNull('parent_id')
            ->with(['children', 'laporanKerusakan'])
            ->withCount('children')
            ->get();
        return view('katalog', compact('gedungs'));
    }

    public function show($id)
    {
        $gedung = \App\Models\Gedung::with(['children', 'parent', 'laporanKerusakan'])->findOrFail($id);

        // Menghitung statistik ruangan & aset secara aman menggunakan schema builder
        $stats = [
            'ruang_kelas' => 0,
            'laboratorium' => 0,
            'kursi' => 0,
            'proyektor' => 0,
            'ac' => 0,
            'total_aset' => 0
        ];

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('ruangans')) {
                $stats['ruang_kelas'] = \Illuminate\Support\Facades\DB::table('ruangans')
                    ->where('gedung_id', $gedung->id)
                    ->where('jenis_ruangan', 'Kelas')
                    ->count();
                    
                $stats['laboratorium'] = \Illuminate\Support\Facades\DB::table('ruangans')
                    ->where('gedung_id', $gedung->id)
                    ->where('jenis_ruangan', 'Laboratorium')
                    ->count();
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('fasilitas_ruangan')) {
                $ruanganIds = \Illuminate\Support\Facades\DB::table('ruangans')
                    ->where('gedung_id', $gedung->id)
                    ->pluck('id');

                if ($ruanganIds->isNotEmpty()) {
                    $stats['kursi'] = \Illuminate\Support\Facades\DB::table('fasilitas_ruangan')
                        ->whereIn('ruangan_id', $ruanganIds)
                        ->where('nama_fasilitas', 'Kursi')
                        ->sum('jumlah') ?? 0;
                        
                    $stats['proyektor'] = \Illuminate\Support\Facades\DB::table('fasilitas_ruangan')
                        ->whereIn('ruangan_id', $ruanganIds)
                        ->where('nama_fasilitas', 'Proyektor')
                        ->sum('jumlah') ?? 0;
                        
                    $stats['ac'] = \Illuminate\Support\Facades\DB::table('fasilitas_ruangan')
                        ->whereIn('ruangan_id', $ruanganIds)
                        ->where('nama_fasilitas', 'AC')
                        ->sum('jumlah') ?? 0;
                        
                    $stats['total_aset'] = \Illuminate\Support\Facades\DB::table('fasilitas_ruangan')
                        ->whereIn('ruangan_id', $ruanganIds)
                        ->sum('jumlah') ?? 0;
                }
            }
        } catch (\Exception $e) {
            // Abaikan error DB jika tabel tidak sesuai
        }

        $punya_departemen = $gedung->children()->exists();

        return view('sub-katalog', compact('gedung', 'stats', 'punya_departemen'));
    }
}
