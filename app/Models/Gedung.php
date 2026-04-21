<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gedung extends Model
{
    protected $fillable = [
        'kode_aset',
        'nama',
        'kategori',
        'deskripsi',
        'lokasi',
        'kondisi',
        'foto',
        'tahun_dibangun',
        'luas_bangunan',
        'parent_id',
    ];

    /**
     * Sub-gedung / departemen di dalam gedung ini.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Gedung::class, 'parent_id');
    }

    /**
     * Gedung induk dari sub-gedung ini.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Gedung::class, 'parent_id');
    }

    /**
     * Laporan kerusakan untuk gedung ini.
     */
    public function laporanKerusakan(): HasMany
    {
        return $this->hasMany(LaporanKerusakan::class);
    }

    /**
     * Aksesor untuk mendapatkan kondisi gedung secara otomatis.
     */
    public function getKondisiAttribute()
    {
        $skor = 0;
        // Hanya hitung laporan yang masih 'Menunggu'
        $laporan = $this->laporanKerusakan()->get();

        foreach ($laporan as $l) {
            if ($l->kondisi === 'Rusak Berat') $skor += 3;
            elseif ($l->kondisi === 'Rusak Sedang') $skor += 2;
            elseif ($l->kondisi === 'Rusak Ringan') $skor += 1;
        }

        if ($skor === 0) return [
            'label' => 'Kondisi Baik',
            'warna' => '#22c55e',
            'icon' => '✅',
            'skor' => $skor
        ];
        elseif ($skor <= 3) return [
            'label' => 'Perlu Perhatian',
            'warna' => '#eab308',
            'icon' => '⚠️',
            'skor' => $skor
        ];
        elseif ($skor <= 7) return [
            'label' => 'Kondisi Sedang',
            'warna' => '#f97316',
            'icon' => '🔶',
            'skor' => $skor
        ];
        else return [
            'label' => 'Kondisi Kritis',
            'warna' => '#ef4444',
            'icon' => '🚨',
            'skor' => $skor
        ];
    }

    /**
     * Aksesor untuk kondisi fakultas (berdasarkan kondisi terburuk departemennya).
     */
    public function getKondisiFakultasAttribute()
    {
        $skorTerburuk = 0;
        
        // Cek skor dari laporan gedung itu sendiri
        $skorTerburuk = $this->kondisi['skor'];

        // Cek skor terburuk dari semua anak (departemen)
        foreach ($this->children as $child) {
            $skorTerburuk = max($skorTerburuk, $child->kondisi['skor']);
        }

        // Return status berdasarkan skor terburuk
        if ($skorTerburuk === 0) return [
            'label' => 'Kondisi Baik',
            'warna' => '#22c55e',
            'icon' => '✅',
            'skor' => $skorTerburuk
        ];
        elseif ($skorTerburuk <= 3) return [
            'label' => 'Perlu Perhatian',
            'warna' => '#eab308',
            'icon' => '⚠️',
            'skor' => $skorTerburuk
        ];
        elseif ($skorTerburuk <= 7) return [
            'label' => 'Kondisi Sedang',
            'warna' => '#f97316',
            'icon' => '🔶',
            'skor' => $skorTerburuk
        ];
        else return [
            'label' => 'Kondisi Kritis',
            'warna' => '#ef4444',
            'icon' => '🚨',
            'skor' => $skorTerburuk
        ];
    }
}
