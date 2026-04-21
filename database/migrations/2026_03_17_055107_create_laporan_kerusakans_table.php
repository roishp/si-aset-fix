<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_kerusakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedung_id')->constrained('gedungs')->onDelete('cascade');
            $table->string('ruangan');
            $table->integer('lantai')->nullable();
            
            $table->enum('kategori', [
                'Meja & Kursi',
                'Elektronik',
                'Toilet & Kebersihan',
                'Pintu & Jendela',
                'Atap & Plafon',
                'Dinding & Cat',
                'Lantai',
                'Instalasi Listrik',
                'Instalasi Air',
                'Tangga & Koridor',
                'Papan Tulis & Proyektor',
                'Kunci & Akses Ruangan',
                'Lainnya'
            ]);
            $table->string('sub_item'); // e.g. "Kursi", "AC", "Kloset"
            
            $table->enum('kondisi', ['Rusak Ringan', 'Rusak Sedang', 'Rusak Berat']);
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            
            // Pelapor
            $table->string('nama_pelapor');
            $table->string('kontak_pelapor')->nullable();
            
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakans');
    }
};
