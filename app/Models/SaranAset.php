<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaranAset extends Model
{
    use HasFactory;

    protected $table = 'saran_aset';

    protected $fillable = [
        'gedung_id',
        'ruangan',
        'nama_aset',
        'jumlah',
        'alasan',
        'foto',
        'nama_pengusul',
        'nim_nip',
        'fakultas',
    ];

    public function gedung(): BelongsTo
    {
        return $this->belongsTo(Gedung::class);
    }
}
