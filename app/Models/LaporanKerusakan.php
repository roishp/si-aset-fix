<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $fillable = [
        'gedung_id',
        'ruangan',
        'lantai',
        'kategori',
        'sub_item',
        'kondisi',
        'deskripsi',
        'foto',
        'nama_pelapor',
        'nim_nip',
        'fakultas',
    ];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }
}
